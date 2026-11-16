import {
  BadRequestException,
  Injectable,
  NotFoundException,
} from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { In, Repository } from 'typeorm';
import { roundMoney, toMoney } from '../common/money.js';
import { Department } from '../organization/department.entity.js';
import { User } from '../users/user.entity.js';
import { BudgetLineUsage } from './budget-line-usage.entity.js';
import { Budget } from './budget.entity.js';
import { BudgetType, BudgetUsageStatus } from './budget.enums.js';

export type BudgetView = Budget & {
  remainingAmount: number;
  underProgressAmount: number;
};

@Injectable()
export class BudgetsService {
  constructor(
    @InjectRepository(Budget)
    private readonly budgetRepository: Repository<Budget>,
    @InjectRepository(BudgetLineUsage)
    private readonly usageRepository: Repository<BudgetLineUsage>,
    @InjectRepository(Department)
    private readonly departmentRepository: Repository<Department>,
  ) {}

  async findAll(): Promise<BudgetView[]> {
    const rows = await this.budgetRepository.find({
      order: { departmentCode: 'ASC', referenceCode: 'ASC' },
    });
    return rows.map((row) => this.toView(row));
  }

  async findAvailable(user: User, budgetType?: BudgetType) {
    const where: {
      departmentCode?: string;
      budgetType?: BudgetType;
      isFrozen: boolean;
    } = { isFrozen: false };

    if (user.department?.departmentCode) {
      where.departmentCode = user.department.departmentCode;
    }
    if (budgetType) {
      where.budgetType = budgetType;
    }

    const rows = await this.budgetRepository.find({
      where,
      order: { description: 'ASC' },
    });

    return rows
      .map((row) => this.toView(row))
      .filter((row) => row.remainingAmount > 0);
  }

  async uploadCsv(fileBuffer: Buffer) {
    const text = fileBuffer.toString('utf8').replace(/^\uFEFF/, '');
    const rows = this.parseCsv(text);
    if (rows.length === 0) {
      throw new BadRequestException('CSV has no data rows');
    }

    const created: Budget[] = [];
    for (const row of rows) {
      const referenceCode = this.cell(row, [
        'reference_code',
        'referencecode',
        'bdesc',
        'description',
      ]);
      const description = this.cell(row, ['description', 'bdesc', 'name']) || referenceCode;
      const departmentCode = this.cell(row, [
        'department_code',
        'departmentcode',
        'bmdept',
        'dept',
      ]).toUpperCase();
      const budgetTypeRaw = this.cell(row, ['budget_type', 'budgettype', 'type']).toLowerCase();
      const totalAmount = toMoney(
        this.cell(row, ['total_amount', 'totalamount', 'btotal', 'total', 'amount']),
      );
      const financialYear =
        this.cell(row, ['financial_year', 'financialyear', 'year']) || '2026';

      if (!referenceCode || !departmentCode || totalAmount <= 0) {
        continue;
      }

      const budgetType =
        budgetTypeRaw === BudgetType.STRATEGIC ? BudgetType.STRATEGIC : BudgetType.ANNUAL;
      const department = await this.departmentRepository.findOne({
        where: { departmentCode },
      });

      const existing = await this.budgetRepository.findOne({
        where: { referenceCode },
      });

      const saved = await this.budgetRepository.save({
        id: existing?.id,
        referenceCode,
        description,
        budgetType,
        departmentCode,
        departmentId: department?.id ?? null,
        financialYear,
        totalAmount: totalAmount.toFixed(2),
        reservedAmount: existing?.reservedAmount ?? '0.00',
        utilizedAmount: existing?.utilizedAmount ?? '0.00',
        isFrozen: existing?.isFrozen ?? false,
      });
      created.push(saved);
    }

    if (created.length === 0) {
      throw new BadRequestException(
        'No valid budget rows found. Use headers: reference_code, description, department_code, budget_type, total_amount, financial_year',
      );
    }

    return {
      importedCount: created.length,
      budgets: created.map((row) => this.toView(row)),
    };
  }

  remainingOf(budget: Budget): number {
    return roundMoney(
      toMoney(budget.totalAmount) -
        toMoney(budget.reservedAmount) -
        toMoney(budget.utilizedAmount),
    );
  }

  async reserveForCapex(
    capexRequestId: number,
    totalAmount: number,
    primaryBudgetLineId: number,
    additionalBudgetLineIds: number[] = [],
  ) {
    const lineIds = [primaryBudgetLineId, ...additionalBudgetLineIds.filter(Boolean)];
    const uniqueIds = [...new Set(lineIds)];
    if (uniqueIds.length !== lineIds.length) {
      throw new BadRequestException('You cannot select the same budget line more than once');
    }
    if (uniqueIds.length > 6) {
      throw new BadRequestException('A request can use at most 6 budget lines');
    }

    const budgets = await this.budgetRepository.find({
      where: { id: In(uniqueIds) },
    });
    const byId = new Map(budgets.map((budget) => [budget.id, budget]));

    let outstanding = roundMoney(totalAmount);
    const usages: BudgetLineUsage[] = [];

    for (const [index, budgetId] of uniqueIds.entries()) {
      if (outstanding <= 0) break;
      const budget = byId.get(budgetId);
      if (!budget) {
        throw new NotFoundException(`Budget line ${budgetId} was not found`);
      }
      if (budget.isFrozen) {
        throw new BadRequestException(`${budget.referenceCode} is frozen`);
      }

      const available = this.remainingOf(budget);
      if (available <= 0) {
        continue;
      }

      const take = roundMoney(Math.min(available, outstanding));
      budget.reservedAmount = roundMoney(toMoney(budget.reservedAmount) + take).toFixed(2);
      await this.budgetRepository.save(budget);

      const usage = this.usageRepository.create({
        capexRequestId,
        budgetLineId: budget.id,
        allocatedAmount: take.toFixed(2),
        isPrimaryLine: index === 0,
        usageStatus: BudgetUsageStatus.RESERVED,
      });
      usages.push(await this.usageRepository.save(usage));
      outstanding = roundMoney(outstanding - take);
    }

    if (outstanding > 0) {
      await this.releaseForCapex(capexRequestId);
      throw new BadRequestException(
        `Insufficient remaining budget. Shortfall: ${outstanding.toFixed(2)}`,
      );
    }

    return usages;
  }

  async releaseForCapex(capexRequestId: number) {
    const usages = await this.usageRepository.find({
      where: {
        capexRequestId,
        usageStatus: BudgetUsageStatus.RESERVED,
      },
    });

    for (const usage of usages) {
      const budget = await this.budgetRepository.findOne({
        where: { id: usage.budgetLineId },
      });
      if (budget) {
        budget.reservedAmount = roundMoney(
          Math.max(0, toMoney(budget.reservedAmount) - toMoney(usage.allocatedAmount)),
        ).toFixed(2);
        await this.budgetRepository.save(budget);
      }
      usage.usageStatus = BudgetUsageStatus.RELEASED;
      await this.usageRepository.save(usage);
    }
  }

  async utilizeForCapex(capexRequestId: number) {
    const usages = await this.usageRepository.find({
      where: {
        capexRequestId,
        usageStatus: BudgetUsageStatus.RESERVED,
      },
    });

    for (const usage of usages) {
      const budget = await this.budgetRepository.findOne({
        where: { id: usage.budgetLineId },
      });
      if (budget) {
        const amount = toMoney(usage.allocatedAmount);
        budget.reservedAmount = roundMoney(
          Math.max(0, toMoney(budget.reservedAmount) - amount),
        ).toFixed(2);
        budget.utilizedAmount = roundMoney(toMoney(budget.utilizedAmount) + amount).toFixed(2);
        await this.budgetRepository.save(budget);
      }
      usage.usageStatus = BudgetUsageStatus.UTILIZED;
      await this.usageRepository.save(usage);
    }
  }

  toView(budget: Budget): BudgetView {
    const remainingAmount = this.remainingOf(budget);
    return Object.assign(budget, {
      remainingAmount,
      underProgressAmount: toMoney(budget.reservedAmount),
    });
  }

  private parseCsv(text: string): Record<string, string>[] {
    const lines = text.split(/\r?\n/).filter((line) => line.trim().length > 0);
    if (lines.length < 2) return [];

    const headers = this.splitCsvLine(lines[0]).map((header) =>
      header.trim().toLowerCase().replace(/\s+/g, '_'),
    );

    return lines.slice(1).map((line) => {
      const cols = this.splitCsvLine(line);
      const row: Record<string, string> = {};
      headers.forEach((header, index) => {
        row[header] = (cols[index] ?? '').trim();
      });
      return row;
    });
  }

  private splitCsvLine(line: string): string[] {
    const result: string[] = [];
    let current = '';
    let inQuotes = false;

    for (let i = 0; i < line.length; i += 1) {
      const char = line[i];
      if (char === '"') {
        inQuotes = !inQuotes;
        continue;
      }
      if (char === ',' && !inQuotes) {
        result.push(current);
        current = '';
        continue;
      }
      current += char;
    }
    result.push(current);
    return result;
  }

  private cell(row: Record<string, string>, keys: string[]): string {
    for (const key of keys) {
      if (row[key]) return row[key];
    }
    return '';
  }
}
