import { BadRequestException, Injectable } from '@nestjs/common';
import { ConfigService } from '@nestjs/config';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { toMoney } from '../common/money.js';
import { LANKA_APPROVAL_ROLES } from '../config/lanka-approval.config.js';
import { Department } from '../organization/department.entity.js';
import { User } from '../users/user.entity.js';
import {
  EXECUTION_ROLES,
  UNIT_APPROVER_ROLES,
  USER_ROLE_LABELS,
  UserRole,
} from '../users/user-role.enum.js';
import { UsersService } from '../users/users.service.js';
import { ApprovalStep } from './approval-step.entity.js';
import { CapexRequest } from './capex.entity.js';
import { APPROVAL_THRESHOLDS, ApprovalStepStatus, CapexCategory } from './capex.enums.js';

type PlannedStep = {
  role: UserRole;
  user: User | null;
};

@Injectable()
export class ApprovalEngineService {
  constructor(
    @InjectRepository(ApprovalStep)
    private readonly stepRepository: Repository<ApprovalStep>,
    private readonly usersService: UsersService,
    private readonly configService: ConfigService,
  ) {}

  async createWorkflow(capex: CapexRequest, originator: User, department: Department) {
    const planned = await this.planSteps(originator, department, toMoney(capex.totalAmount), capex.category);
    if (planned.length === 0) {
      throw new BadRequestException('No approval chain could be built for this user');
    }

    const steps: ApprovalStep[] = [];
    for (const [index, item] of planned.entries()) {
      const step = this.stepRepository.create({
        capexRequestId: capex.id,
        sequenceNumber: index + 1,
        approverRole: item.role,
        assignedUserId: item.user?.id ?? null,
        stepStatus: index === 0 ? ApprovalStepStatus.PENDING : ApprovalStepStatus.WAITING,
      });
      steps.push(await this.stepRepository.save(step));
    }

    return steps;
  }

  async planSteps(
    originator: User,
    department: Department,
    totalAmount: number,
    category: CapexCategory,
  ): Promise<PlannedStep[]> {
    if (this.configService.get<boolean>('site.isLankaOnly') ?? true) {
      return this.planLankaSteps();
    }

    const planned: PlannedStep[] = [];
    const seen = new Set<number>();

    let cursor = originator.reportsToUserId
      ? await this.usersService.findById(originator.reportsToUserId)
      : originator.reportsTo;

    while (cursor) {
      if (seen.has(cursor.id)) break;
      seen.add(cursor.id);
      if (UNIT_APPROVER_ROLES.includes(cursor.role)) {
        planned.push({ role: cursor.role, user: cursor });
      }
      if (cursor.role === UserRole.BUM) break;
      cursor = cursor.reportsToUserId
        ? await this.usersService.findById(cursor.reportsToUserId)
        : null;
    }

    const functionalHead = await this.usersService.findByRole(department.functionalHeadRole);
    if (functionalHead) {
      planned.push({ role: department.functionalHeadRole, user: functionalHead });
    }

    const financialController = await this.usersService.findByRole(UserRole.FINANCIAL_CONTROLLER);
    if (financialController) {
      planned.push({ role: UserRole.FINANCIAL_CONTROLLER, user: financialController });
    }

    if (totalAmount > APPROVAL_THRESHOLDS.cfoAndManagingDirector) {
      const cfo = await this.usersService.findByRole(UserRole.CFO);
      if (cfo) planned.push({ role: UserRole.CFO, user: cfo });

      if (category !== CapexCategory.ENTITLEMENTS) {
        const managingDirector = await this.usersService.findByRole(UserRole.MANAGING_DIRECTOR);
        if (managingDirector) {
          planned.push({ role: UserRole.MANAGING_DIRECTOR, user: managingDirector });
        }
      }
    }

    for (const role of EXECUTION_ROLES) {
      const user = await this.usersService.findByRole(role);
      if (user) planned.push({ role, user });
    }

    return planned;
  }

  private async planLankaSteps(): Promise<PlannedStep[]> {
    const planned: PlannedStep[] = [];
    for (const role of LANKA_APPROVAL_ROLES) {
      const user = await this.usersService.findByRole(role);
      planned.push({ role, user });
    }
    return planned;
  }

  stageLabel(role: UserRole | null): string {
    if (!role) return 'Completed';
    return USER_ROLE_LABELS[role];
  }
}
