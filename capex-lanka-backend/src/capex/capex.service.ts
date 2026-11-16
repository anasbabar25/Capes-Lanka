import {
  BadRequestException,
  ForbiddenException,
  Injectable,
  NotFoundException,
} from '@nestjs/common';
import { ConfigService } from '@nestjs/config';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { roundMoney, toMoney } from '../common/money.js';
import { parsePagination, toPaginatedResult, type PaginatedResult } from '../common/pagination.js';
import {
  isLankaApprovalRole,
  LANKA_APPROVAL_ROLES,
  sortByLankaApprovalOrder,
} from '../config/lanka-approval.config.js';
import { BudgetsService } from '../budgets/budgets.service.js';
import { User } from '../users/user.entity.js';
import { UsersService } from '../users/users.service.js';
import { UserRole } from '../users/user-role.enum.js';
import { ApprovalEngineService } from './approval-engine.service.js';
import { ApprovalStep } from './approval-step.entity.js';
import { CapexComment } from './capex-comment.entity.js';
import { CapexRequest } from './capex.entity.js';
import { CapexStatus } from './capex-status.enum.js';
import {
  APPROVAL_THRESHOLDS,
  ApprovalStepStatus,
  BudgetedOption,
  CapexCategory,
} from './capex.enums.js';
import { CreateCapexDto } from './dto/create-capex.dto.js';
import { ApprovalDecision, DecideCapexDto } from './dto/decide-capex.dto.js';

export type CapexListFilters = {
  search?: string;
  status?: string;
  currentStage?: string;
};

@Injectable()
export class CapexService {
  constructor(
    @InjectRepository(CapexRequest)
    private readonly capexRepository: Repository<CapexRequest>,
    @InjectRepository(ApprovalStep)
    private readonly stepRepository: Repository<ApprovalStep>,
    @InjectRepository(CapexComment)
    private readonly commentRepository: Repository<CapexComment>,
    private readonly budgetsService: BudgetsService,
    private readonly approvalEngine: ApprovalEngineService,
    private readonly usersService: UsersService,
    private readonly configService: ConfigService,
  ) {}

  private isLankaSite() {
    return this.configService.get<boolean>('site.isLankaOnly') ?? true;
  }

  private filterApprovalStepsForSite(steps: ApprovalStep[]) {
    if (!this.isLankaSite()) {
      return steps;
    }
    return sortByLankaApprovalOrder(
      steps.filter((step) => isLankaApprovalRole(step.approverRole)),
    );
  }

  private applyListScope(user: User) {
    const query = this.capexRepository
      .createQueryBuilder('capex')
      .leftJoinAndSelect('capex.originatingDepartment', 'department')
      .leftJoinAndSelect('capex.createdBy', 'createdBy')
      .leftJoinAndSelect('capex.currentApprover', 'currentApprover')
      .orderBy('capex.createdAt', 'DESC');

    if (user.role === UserRole.ORIGINATOR) {
      query.andWhere('capex.createdByUserId = :userId', { userId: user.id });
    }

    return query;
  }

  private applyListFilters(query: ReturnType<typeof this.applyListScope>, filters?: CapexListFilters) {
    const search = filters?.search?.trim();
    if (search) {
      query.andWhere(
        `(capex.referenceNo LIKE :search OR capex.desiredAssetNameSap LIKE :search OR capex.costCenter LIKE :search OR department.departmentName LIKE :search OR createdBy.displayName LIKE :search)`,
        { search: `%${search}%` },
      );
    }

    if (filters?.status && Object.values(CapexStatus).includes(filters.status as CapexStatus)) {
      query.andWhere('capex.status = :status', { status: filters.status });
    }

    if (filters?.currentStage) {
      if (filters.currentStage === 'completed') {
        query.andWhere('capex.currentStage IS NULL');
      } else if (Object.values(UserRole).includes(filters.currentStage as UserRole)) {
        query.andWhere(
          `(capex.currentStage = :currentStage OR EXISTS (
            SELECT 1 FROM approval_steps stageFilter
            WHERE stageFilter.capexRequestId = capex.id
              AND stageFilter.stepStatus = :pendingStepStatus
              AND stageFilter.approverRole = :currentStage
          ))`,
          {
            currentStage: filters.currentStage,
            pendingStepStatus: ApprovalStepStatus.PENDING,
          },
        );
      }
    }

    return query;
  }

  private async applyDisplayStageFromSteps(records: CapexRequest[]) {
    const pendingCapexIds = records
      .filter((record) => record.status === CapexStatus.PENDING)
      .map((record) => record.id);
    if (pendingCapexIds.length === 0) {
      return records;
    }

    const pendingQuery = this.stepRepository
      .createQueryBuilder('step')
      .where('step.capexRequestId IN (:...pendingCapexIds)', { pendingCapexIds })
      .andWhere('step.stepStatus = :pending', { pending: ApprovalStepStatus.PENDING })
      .orderBy('step.sequenceNumber', 'ASC');

    if (this.isLankaSite()) {
      pendingQuery.andWhere('step.approverRole IN (:...lankaRoles)', {
        lankaRoles: LANKA_APPROVAL_ROLES,
      });
    }

    const pendingSteps = await pendingQuery.getMany();

    const pendingStepsByCapex = new Map<number, ApprovalStep[]>();
    for (const step of pendingSteps) {
      const existing = pendingStepsByCapex.get(step.capexRequestId) ?? [];
      existing.push(step);
      pendingStepsByCapex.set(step.capexRequestId, existing);
    }

    for (const record of records) {
      const steps = pendingStepsByCapex.get(record.id) ?? [];
      const pendingStep = steps[0];
      if (pendingStep) {
        record.currentStage = pendingStep.approverRole;
        record.currentApproverUserId = pendingStep.assignedUserId;
      }
      // Keep the full approval chain when already loaded (e.g. detail view).
      if (!record.approvalSteps?.length && steps.length > 0) {
        record.approvalSteps = steps;
      }
    }

    return records;
  }

  private findPendingStepForUser(steps: ApprovalStep[], user: User) {
    return steps.find(
      (step) =>
        step.stepStatus === ApprovalStepStatus.PENDING &&
        (user.role === UserRole.ADMIN ||
          step.assignedUserId === user.id ||
          (!step.assignedUserId && step.approverRole === user.role)),
    );
  }

  async findAll(
    user: User,
    pageInput?: string,
    limitInput?: string,
    filters?: CapexListFilters,
  ): Promise<PaginatedResult<CapexRequest>> {
    const { page, limit } = parsePagination(pageInput, limitInput);
    const [data, total] = await this.applyListFilters(this.applyListScope(user), filters)
      .skip((page - 1) * limit)
      .take(limit)
      .getManyAndCount();

    await this.applyDisplayStageFromSteps(data);

    return toPaginatedResult(data, total, page, limit);
  }

  async findPendingFor(user: User) {
    const records = await this.capexRepository
      .createQueryBuilder('capex')
      .leftJoinAndSelect('capex.originatingDepartment', 'department')
      .leftJoinAndSelect('capex.createdBy', 'createdBy')
      .leftJoinAndSelect('capex.currentApprover', 'currentApprover')
      .where('capex.status = :status', { status: CapexStatus.PENDING })
      .andWhere(
        `EXISTS (
          SELECT 1 FROM approval_steps pendingStep
          WHERE pendingStep.capexRequestId = capex.id
            AND pendingStep.stepStatus = :pendingStepStatus
            AND (
              pendingStep.assignedUserId = :userId
              OR (pendingStep.assignedUserId IS NULL AND pendingStep.approverRole = :role)
            )
            ${this.isLankaSite() ? 'AND pendingStep.approverRole IN (:...lankaRoles)' : ''}
        )`,
        {
          pendingStepStatus: ApprovalStepStatus.PENDING,
          userId: user.id,
          role: user.role,
          ...(this.isLankaSite() ? { lankaRoles: LANKA_APPROVAL_ROLES } : {}),
        },
      )
      .orderBy('capex.createdAt', 'ASC')
      .getMany();

    return this.applyDisplayStageFromSteps(records);
  }

  async getStats(user: User) {
    const statsQuery = this.capexRepository.createQueryBuilder('capex');
    if (user.role === UserRole.ORIGINATOR) {
      statsQuery.andWhere('capex.createdByUserId = :userId', { userId: user.id });
    }

    const rows = await statsQuery
      .select('capex.status', 'status')
      .addSelect('COUNT(*)', 'count')
      .groupBy('capex.status')
      .getRawMany<{ status: CapexStatus; count: string }>();

    const countByStatus = new Map(rows.map((row) => [row.status, Number(row.count)]));

    return {
      total: rows.reduce((sum, row) => sum + Number(row.count), 0),
      approved: countByStatus.get(CapexStatus.APPROVED) ?? 0,
      pending: countByStatus.get(CapexStatus.PENDING) ?? 0,
      rejected: countByStatus.get(CapexStatus.REJECTED) ?? 0,
      returned: countByStatus.get(CapexStatus.RETURNED) ?? 0,
    };
  }

  async findOne(id: number) {
    const capex = await this.capexRepository.findOne({
      where: { id },
      relations: {
        originatingDepartment: true,
        createdBy: true,
        currentApprover: true,
        approvalSteps: { assignedUser: true, decidedBy: true },
        comments: { author: true },
        budgetUsages: { budgetLine: true },
      },
    });
    if (!capex) {
      throw new NotFoundException('Capex request not found');
    }

    capex.approvalSteps = this.filterApprovalStepsForSite(
      (capex.approvalSteps ?? []).sort((a, b) => a.sequenceNumber - b.sequenceNumber),
    );
    await this.applyDisplayStageFromSteps([capex]);
    return capex;
  }

  async create(dto: CreateCapexDto, user: User) {
    if (user.role !== UserRole.ORIGINATOR && user.role !== UserRole.ADMIN) {
      throw new ForbiddenException('Only originating department users can submit a CEP');
    }
    if (!user.department) {
      throw new BadRequestException('Originator is not assigned to a department');
    }
    if (user.department.isBudgetFrozen) {
      throw new BadRequestException('Budget entry is frozen for this department');
    }

    const totalAmount = this.computeTotal(dto);
    if (totalAmount <= 0) {
      throw new BadRequestException('Project cost must be greater than zero');
    }

    if (dto.budgeted === BudgetedOption.NO && !user.department.allowsUnbudgetedRequests) {
      throw new BadRequestException('Unbudgeted requests are not allowed for this department');
    }

    const count = await this.capexRepository.count();
    const referenceNo = `CEP-${String(count + 1).padStart(5, '0')}`;

    const capex = this.capexRepository.create({
      referenceNo,
      costCenter: dto.costCenter,
      originatingDepartmentId: user.department.id,
      budgeted: dto.budgeted,
      expectedCompletionDate: dto.expectedCompletionDate,
      replacementExpansion: dto.replacementExpansion,
      category: dto.category,
      detailOfProposal: dto.detailOfProposal,
      desiredAssetNameSap: dto.desiredAssetNameSap,
      inHouseAvailability: dto.inHouseAvailability,
      enteredByEmail: dto.enteredByEmail,
      extensionNumber: dto.extensionNumber,
      localCost: this.money(dto.localCost),
      importedCost: this.money(dto.importedCost),
      currencyCode: dto.currencyCode ?? null,
      foreignCurrencyAmount: this.money(dto.foreignCurrencyAmount),
      exchangeRate: this.money(dto.exchangeRate, 4),
      localCustomsDuty: this.money(dto.localCustomsDuty),
      importedCustomsDuty: this.money(dto.importedCustomsDuty),
      localOtherCost: this.money(dto.localOtherCost),
      importedOtherCost: this.money(dto.importedOtherCost),
      localGst:
        dto.category === CapexCategory.PLANT_AND_MACHINERY ? '0.00' : this.money(dto.localGst),
      importedGst:
        dto.category === CapexCategory.PLANT_AND_MACHINERY ? '0.00' : this.money(dto.importedGst),
      totalAmount: totalAmount.toFixed(2),
      status: CapexStatus.PENDING,
      createdByUserId: user.id,
    });

    const saved = await this.capexRepository.save(capex);

    if (dto.budgeted !== BudgetedOption.NO) {
      if (!dto.primaryBudgetLineId) {
        throw new BadRequestException('A budget reference is required');
      }
      const extraIds = user.department.allowsBudgetVirement
        ? dto.additionalBudgetLineIds ?? []
        : [];
      await this.budgetsService.reserveForCapex(
        saved.id,
        totalAmount,
        dto.primaryBudgetLineId,
        extraIds,
      );
    }

    const originator = (await this.usersService.findById(user.id)) ?? user;
    const steps = await this.approvalEngine.createWorkflow(
      saved,
      originator,
      user.department,
    );
    const first = steps[0];
    saved.currentStage = first.approverRole;
    saved.currentApproverUserId = first.assignedUserId;
    await this.capexRepository.save(saved);

    return this.findOne(saved.id);
  }

  async decide(id: number, dto: DecideCapexDto, user: User) {
    const capex = await this.findOne(id);
    const current = this.findPendingStepForUser(capex.approvalSteps, user);
    if (!current) {
      throw new BadRequestException('This request is not waiting for your decision');
    }

    if (dto.decision === ApprovalDecision.REJECT || dto.decision === ApprovalDecision.RETURN) {
      current.stepStatus = ApprovalStepStatus.REJECTED;
      current.decisionComments = dto.comments;
      current.decidedAt = new Date();
      current.decidedByUserId = user.id;
      await this.stepRepository.save(current);
      await this.addComment(capex.id, user.id, dto.comments);

      capex.status =
        dto.decision === ApprovalDecision.RETURN ? CapexStatus.RETURNED : CapexStatus.REJECTED;
      capex.currentStage = null;
      capex.currentApproverUserId = null;
      await this.capexRepository.save(capex);
      await this.budgetsService.releaseForCapex(capex.id);
      return this.findOne(capex.id);
    }

    this.assertApprovalFields(current.approverRole, capex, dto);

    if (current.approverRole === UserRole.FINANCIAL_CONTROLLER) {
      capex.paybackPeriod = dto.paybackPeriod ?? capex.paybackPeriod;
      capex.internalRateOfReturn =
        dto.internalRateOfReturn != null
          ? dto.internalRateOfReturn.toFixed(2)
          : capex.internalRateOfReturn;
    }

    if (current.approverRole === UserRole.INVENTORY) {
      capex.glAccountNumber = dto.glAccountNumber ?? null;
      capex.internalOrderNumber = dto.internalOrderNumber ?? null;
      capex.capexFormNumber = dto.capexFormNumber ?? null;
      await this.budgetsService.utilizeForCapex(capex.id);
    }

    if (current.approverRole === UserRole.ERP) {
      capex.purchaseRequisitionNumber = dto.purchaseRequisitionNumber ?? null;
    }

    if (current.approverRole === UserRole.SUPPLY_CHAIN) {
      capex.purchaseOrderNumber = dto.purchaseOrderNumber ?? null;
    }

    current.stepStatus = ApprovalStepStatus.APPROVED;
    current.decisionComments = dto.comments;
    current.decidedAt = new Date();
    current.decidedByUserId = user.id;
    await this.stepRepository.save(current);
    await this.addComment(capex.id, user.id, dto.comments);

    const otherPending = capex.approvalSteps.filter(
      (step) => step.id !== current.id && step.stepStatus === ApprovalStepStatus.PENDING,
    );

    if (otherPending.length > 0) {
      const nextPending = otherPending.sort((a, b) => a.sequenceNumber - b.sequenceNumber)[0];
      capex.currentStage = nextPending.approverRole;
      capex.currentApproverUserId = nextPending.assignedUserId;
    } else {
      const nextWaiting = capex.approvalSteps
        .filter((step) => step.stepStatus === ApprovalStepStatus.WAITING)
        .sort((a, b) => a.sequenceNumber - b.sequenceNumber)[0];

      if (nextWaiting) {
        nextWaiting.stepStatus = ApprovalStepStatus.PENDING;
        await this.stepRepository.save(nextWaiting);
        capex.currentStage = nextWaiting.approverRole;
        capex.currentApproverUserId = nextWaiting.assignedUserId;
      } else {
        capex.status = CapexStatus.APPROVED;
        capex.currentStage = null;
        capex.currentApproverUserId = null;
      }
    }

    await this.capexRepository.save(capex);
    return this.findOne(capex.id);
  }

  private assertApprovalFields(
    role: UserRole,
    capex: CapexRequest,
    dto: DecideCapexDto,
  ) {
    const amount = toMoney(capex.totalAmount);

    if (
      role === UserRole.FINANCIAL_CONTROLLER &&
      amount > APPROVAL_THRESHOLDS.financialControllerPaybackRequired
    ) {
      if (!dto.paybackPeriod || dto.internalRateOfReturn == null) {
        throw new BadRequestException(
          'Payback and IRR are required for Financial Controller approval above Rs 1 million',
        );
      }
    }

    if (role === UserRole.INVENTORY) {
      if (!dto.glAccountNumber || !dto.internalOrderNumber) {
        throw new BadRequestException(
          'GL account number and Internal Order number are required for Inventory approval',
        );
      }
    }

    if (role === UserRole.ERP && !dto.purchaseRequisitionNumber) {
      throw new BadRequestException('Purchase requisition number is required');
    }

    if (role === UserRole.SUPPLY_CHAIN && !dto.purchaseOrderNumber) {
      throw new BadRequestException('Purchase order number is required');
    }
  }

  private computeTotal(dto: CreateCapexDto): number {
    const gstLocal =
      dto.category === CapexCategory.PLANT_AND_MACHINERY ? 0 : toMoney(dto.localGst);
    const gstImported =
      dto.category === CapexCategory.PLANT_AND_MACHINERY ? 0 : toMoney(dto.importedGst);

    return roundMoney(
      toMoney(dto.localCost) +
        toMoney(dto.importedCost) +
        toMoney(dto.localCustomsDuty) +
        toMoney(dto.importedCustomsDuty) +
        toMoney(dto.localOtherCost) +
        toMoney(dto.importedOtherCost) +
        gstLocal +
        gstImported,
    );
  }

  private money(value?: number, scale = 2): string {
    return toMoney(value).toFixed(scale);
  }

  private addComment(capexRequestId: number, authorUserId: number, message: string) {
    return this.commentRepository.save(
      this.commentRepository.create({ capexRequestId, authorUserId, message }),
    );
  }

}
