import { Injectable, OnModuleInit } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import * as bcrypt from 'bcryptjs';
import { Repository } from 'typeorm';
import { Budget } from '../budgets/budget.entity.js';
import { BudgetType } from '../budgets/budget.enums.js';
import { Department } from '../organization/department.entity.js';
import { User } from '../users/user.entity.js';
import { USER_ROLE_LABELS, UserRole } from '../users/user-role.enum.js';

@Injectable()
export class SeedService implements OnModuleInit {
  constructor(
    @InjectRepository(Department)
    private readonly departmentRepository: Repository<Department>,
    @InjectRepository(User)
    private readonly usersRepository: Repository<User>,
    @InjectRepository(Budget)
    private readonly budgetRepository: Repository<Budget>,
  ) {}

  async onModuleInit() {
    if (process.env.SKIP_DEMO_SEED === 'true') {
      return;
    }

    await this.seedDepartments();
    await this.seedUsers();
    await this.seedBudgets();
  }

  private async seedDepartments() {
    const isLankaOnly = (process.env.SITE_SCOPE ?? 'LANKA') === 'LANKA';

    const departments: Array<Partial<Department>> = isLankaOnly
      ? [
          {
            departmentCode: 'LANKA',
            departmentName: 'Packages Lanka',
            functionalHeadRole: UserRole.HEAD_OF_PACKAGING,
            allowsUnbudgetedRequests: true,
            allowsBudgetVirement: true,
          },
          {
            departmentCode: 'CORP',
            departmentName: 'Corporate / Executives',
            functionalHeadRole: UserRole.HEAD_OF_PACKAGING,
            allowsUnbudgetedRequests: true,
            allowsBudgetVirement: true,
          },
        ]
      : [
          {
            departmentCode: 'BUFC',
            departmentName: 'Flexible Packaging',
            functionalHeadRole: UserRole.HEAD_OF_PACKAGING,
            allowsUnbudgetedRequests: false,
            allowsBudgetVirement: false,
          },
          {
            departmentCode: 'CORP',
            departmentName: 'Corporate',
            functionalHeadRole: UserRole.HEAD_OF_PACKAGING,
            allowsUnbudgetedRequests: true,
            allowsBudgetVirement: true,
          },
        ];

    for (const item of departments) {
      const existing = await this.departmentRepository.findOne({
        where: { departmentCode: item.departmentCode },
      });
      await this.departmentRepository.save({
        ...existing,
        ...item,
        isActive: true,
        isBudgetFrozen: existing?.isBudgetFrozen ?? false,
      });
    }
  }

  private async seedUsers() {
    const password = await bcrypt.hash('admin123', 10);

    const legacyUsernames = ['user', 'manager', 'bum-hod-hop-cfo', 'managing-director'];
    for (const username of legacyUsernames) {
      const legacy = await this.usersRepository.findOne({ where: { username } });
      if (legacy) {
        legacy.isActive = false;
        await this.usersRepository.save(legacy);
      }
    }

    const byCode = async (code: string) =>
      this.departmentRepository.findOne({ where: { departmentCode: code } });

    const bufc = await byCode('BUFC');
    const bumf = await byCode('BUMF');
    const bucp = await byCode('BUCP');
    const systems = await byCode('SYSTEMS');
    const hr = await byCode('HR');
    const sm = await byCode('SM');
    const corp = await byCode('CORP');

    const users: Array<{
      username: string;
      role: UserRole;
      email: string;
      departmentId: number | null;
      reportsToUsername?: string;
    }> = [
      { username: 'admin', role: UserRole.ADMIN, email: 'admin@capexlanka.com', departmentId: corp?.id ?? null },
      { username: 'originator.bufc', role: UserRole.ORIGINATOR, email: 'originator.bufc@capexlanka.com', departmentId: bufc?.id ?? null, reportsToUsername: 'hod.bufc' },
      { username: 'hod.bufc', role: UserRole.HOD, email: 'hod.bufc@capexlanka.com', departmentId: bufc?.id ?? null, reportsToUsername: 'bc.bufc' },
      { username: 'bc.bufc', role: UserRole.BUSINESS_CONTROLLER, email: 'bc.bufc@capexlanka.com', departmentId: bufc?.id ?? null, reportsToUsername: 'bum.packaging' },
      { username: 'originator.bumf', role: UserRole.ORIGINATOR, email: 'originator.bumf@capexlanka.com', departmentId: bumf?.id ?? null, reportsToUsername: 'hod.bumf' },
      { username: 'hod.bumf', role: UserRole.HOD, email: 'hod.bumf@capexlanka.com', departmentId: bumf?.id ?? null, reportsToUsername: 'bc.bufc' },
      { username: 'originator.bucp', role: UserRole.ORIGINATOR, email: 'originator.bucp@capexlanka.com', departmentId: bucp?.id ?? null, reportsToUsername: 'hod.bucp' },
      { username: 'hod.bucp', role: UserRole.HOD, email: 'hod.bucp@capexlanka.com', departmentId: bucp?.id ?? null, reportsToUsername: 'bc.bufc' },
      { username: 'originator.systems', role: UserRole.ORIGINATOR, email: 'originator.systems@capexlanka.com', departmentId: systems?.id ?? null, reportsToUsername: 'hod.systems' },
      { username: 'hod.systems', role: UserRole.HOD, email: 'hod.systems@capexlanka.com', departmentId: systems?.id ?? null, reportsToUsername: 'bc.bufc' },
      { username: 'originator.hr', role: UserRole.ORIGINATOR, email: 'originator.hr@capexlanka.com', departmentId: hr?.id ?? null, reportsToUsername: 'hod.hr' },
      { username: 'hod.hr', role: UserRole.HOD, email: 'hod.hr@capexlanka.com', departmentId: hr?.id ?? null, reportsToUsername: 'bc.bufc' },
      { username: 'originator.sm', role: UserRole.ORIGINATOR, email: 'originator.sm@capexlanka.com', departmentId: sm?.id ?? null, reportsToUsername: 'hod.sm' },
      { username: 'hod.sm', role: UserRole.HOD, email: 'hod.sm@capexlanka.com', departmentId: sm?.id ?? null, reportsToUsername: 'bc.bufc' },
      { username: 'bum.packaging', role: UserRole.BUM, email: 'bum.packaging@capexlanka.com', departmentId: bufc?.id ?? null },
      { username: 'hop', role: UserRole.HEAD_OF_PACKAGING, email: 'hop@capexlanka.com', departmentId: corp?.id ?? null },
      { username: 'hoe', role: UserRole.HEAD_OF_ENGINEERING, email: 'hoe@capexlanka.com', departmentId: corp?.id ?? null },
      { username: 'hcd', role: UserRole.HEAD_OF_CONSUMER_DIVISION, email: 'hcd@capexlanka.com', departmentId: corp?.id ?? null },
      { username: 'ghit', role: UserRole.GROUP_HEAD_IT, email: 'ghit@capexlanka.com', departmentId: corp?.id ?? null },
      { username: 'ghhr', role: UserRole.GROUP_HEAD_HR, email: 'ghhr@capexlanka.com', departmentId: corp?.id ?? null },
      { username: 'gsm', role: UserRole.GROUP_HEAD_SUPPLY_CHAIN, email: 'gsm@capexlanka.com', departmentId: corp?.id ?? null },
      { username: 'financial.controller', role: UserRole.FINANCIAL_CONTROLLER, email: 'fc@capexlanka.com', departmentId: corp?.id ?? null },
      { username: 'cfo', role: UserRole.CFO, email: 'cfo@capexlanka.com', departmentId: corp?.id ?? null },
      { username: 'md', role: UserRole.MANAGING_DIRECTOR, email: 'md@capexlanka.com', departmentId: corp?.id ?? null },
      { username: 'inventory', role: UserRole.INVENTORY, email: 'inventory@capexlanka.com', departmentId: corp?.id ?? null },
      { username: 'erp', role: UserRole.ERP, email: 'erp@capexlanka.com', departmentId: corp?.id ?? null },
      { username: 'supply.chain', role: UserRole.SUPPLY_CHAIN, email: 'scm@capexlanka.com', departmentId: corp?.id ?? null },
    ];

    for (const item of users) {
      const existing = await this.usersRepository.findOne({ where: { username: item.username } });
      await this.usersRepository.save({
        ...existing,
        username: item.username,
        password,
        email: item.email,
        displayName: `${USER_ROLE_LABELS[item.role]} (${item.username})`,
        role: item.role,
        departmentId: item.departmentId,
        isActive: true,
      });
    }

    for (const item of users) {
      if (!item.reportsToUsername) continue;
      const user = await this.usersRepository.findOne({ where: { username: item.username } });
      const manager = await this.usersRepository.findOne({
        where: { username: item.reportsToUsername },
      });
      if (user && manager) {
        user.reportsToUserId = manager.id;
        await this.usersRepository.save(user);
      }
    }
  }

  private async seedBudgets() {
    const count = await this.budgetRepository.count();
    if (count > 0) return;

    const bufc = await this.departmentRepository.findOne({ where: { departmentCode: 'BUFC' } });
    const bumf = await this.departmentRepository.findOne({ where: { departmentCode: 'BUMF' } });
    const systems = await this.departmentRepository.findOne({ where: { departmentCode: 'SYSTEMS' } });

    await this.budgetRepository.save([
      {
        referenceCode: 'BUD-BUFC-001',
        description: 'Flexible Packaging plant upgrade',
        budgetType: BudgetType.ANNUAL,
        departmentCode: 'BUFC',
        departmentId: bufc?.id ?? null,
        financialYear: '2026',
        totalAmount: '8000000.00',
        reservedAmount: '0.00',
        utilizedAmount: '0.00',
      },
      {
        referenceCode: 'BUD-BUFC-002',
        description: 'Flexible Packaging spare machinery',
        budgetType: BudgetType.ANNUAL,
        departmentCode: 'BUFC',
        departmentId: bufc?.id ?? null,
        financialYear: '2026',
        totalAmount: '1500000.00',
        reservedAmount: '0.00',
        utilizedAmount: '0.00',
      },
      {
        referenceCode: 'SBUD-BUFC-001',
        description: 'Flexible Packaging strategic automation',
        budgetType: BudgetType.STRATEGIC,
        departmentCode: 'BUFC',
        departmentId: bufc?.id ?? null,
        financialYear: '2026',
        totalAmount: '5000000.00',
        reservedAmount: '0.00',
        utilizedAmount: '0.00',
      },
      {
        referenceCode: 'BUD-BUMF-001',
        description: 'Engineering equipment replacement',
        budgetType: BudgetType.ANNUAL,
        departmentCode: 'BUMF',
        departmentId: bumf?.id ?? null,
        financialYear: '2026',
        totalAmount: '3500000.00',
        reservedAmount: '0.00',
        utilizedAmount: '0.00',
      },
      {
        referenceCode: 'BUD-SYS-001',
        description: 'IT infrastructure modernization',
        budgetType: BudgetType.ANNUAL,
        departmentCode: 'SYSTEMS',
        departmentId: systems?.id ?? null,
        financialYear: '2026',
        totalAmount: '2500000.00',
        reservedAmount: '0.00',
        utilizedAmount: '0.00',
      },
    ]);
  }
}
