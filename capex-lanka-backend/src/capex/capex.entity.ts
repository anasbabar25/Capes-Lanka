import {
  Column,
  CreateDateColumn,
  Entity,
  JoinColumn,
  ManyToOne,
  OneToMany,
  PrimaryGeneratedColumn,
  UpdateDateColumn,
} from 'typeorm';
import { Department } from '../organization/department.entity.js';
import { User } from '../users/user.entity.js';
import { UserRole } from '../users/user-role.enum.js';
import { CapexStatus } from './capex-status.enum.js';
import {
  BudgetedOption,
  CapexCategory,
  ReplacementExpansionOption,
  YesNoOption,
} from './capex.enums.js';
import type { ApprovalStep } from './approval-step.entity.js';
import type { CapexComment } from './capex-comment.entity.js';
import type { BudgetLineUsage } from '../budgets/budget-line-usage.entity.js';

@Entity('capex_requests')
export class CapexRequest {
  @PrimaryGeneratedColumn()
  id!: number;

  @Column({ unique: true })
  referenceNo!: string;

  @Column()
  costCenter!: string;

  @ManyToOne(() => Department, { eager: true })
  @JoinColumn({ name: 'originatingDepartmentId' })
  originatingDepartment!: Department;

  @Column()
  originatingDepartmentId!: number;

  @Column({ type: 'varchar', length: 32 })
  budgeted!: BudgetedOption;

  @Column({ type: 'date' })
  expectedCompletionDate!: string;

  @Column({ type: 'varchar', length: 32 })
  replacementExpansion!: ReplacementExpansionOption;

  @Column({ type: 'varchar', length: 64 })
  category!: CapexCategory;

  @Column({ type: 'text' })
  detailOfProposal!: string;

  @Column()
  desiredAssetNameSap!: string;

  @Column({ type: 'varchar', length: 16 })
  inHouseAvailability!: YesNoOption;

  @Column()
  enteredByEmail!: string;

  @Column()
  extensionNumber!: string;

  @Column({ type: 'decimal', precision: 14, scale: 2, default: 0 })
  localCost!: string;

  @Column({ type: 'decimal', precision: 14, scale: 2, default: 0 })
  importedCost!: string;

  @Column({ type: 'varchar', length: 8, nullable: true })
  currencyCode!: string | null;

  @Column({ type: 'decimal', precision: 14, scale: 2, default: 0 })
  foreignCurrencyAmount!: string;

  @Column({ type: 'decimal', precision: 12, scale: 4, default: 0 })
  exchangeRate!: string;

  @Column({ type: 'decimal', precision: 14, scale: 2, default: 0 })
  localCustomsDuty!: string;

  @Column({ type: 'decimal', precision: 14, scale: 2, default: 0 })
  importedCustomsDuty!: string;

  @Column({ type: 'decimal', precision: 14, scale: 2, default: 0 })
  localOtherCost!: string;

  @Column({ type: 'decimal', precision: 14, scale: 2, default: 0 })
  importedOtherCost!: string;

  @Column({ type: 'decimal', precision: 14, scale: 2, default: 0 })
  localGst!: string;

  @Column({ type: 'decimal', precision: 14, scale: 2, default: 0 })
  importedGst!: string;

  @Column({ type: 'decimal', precision: 14, scale: 2, default: 0 })
  totalAmount!: string;

  @Column({ type: 'varchar', length: 64, nullable: true })
  paybackPeriod!: string | null;

  @Column({ type: 'decimal', precision: 8, scale: 2, nullable: true })
  internalRateOfReturn!: string | null;

  @Column({ type: 'varchar', length: 64, nullable: true })
  glAccountNumber!: string | null;

  @Column({ type: 'varchar', length: 64, nullable: true })
  internalOrderNumber!: string | null;

  @Column({ type: 'varchar', length: 64, nullable: true })
  capexFormNumber!: string | null;

  @Column({ type: 'varchar', length: 64, nullable: true })
  purchaseRequisitionNumber!: string | null;

  @Column({ type: 'varchar', length: 64, nullable: true })
  purchaseOrderNumber!: string | null;

  @Column({ type: 'varchar', length: 32, default: CapexStatus.PENDING })
  status!: CapexStatus;

  @Column({ type: 'varchar', length: 64, nullable: true })
  currentStage!: UserRole | null;

  @ManyToOne(() => User, { eager: true, nullable: true })
  @JoinColumn({ name: 'currentApproverUserId' })
  currentApprover!: User | null;

  @Column({ nullable: true })
  currentApproverUserId!: number | null;

  @ManyToOne(() => User, { eager: true })
  @JoinColumn({ name: 'createdByUserId' })
  createdBy!: User;

  @Column()
  createdByUserId!: number;

  @OneToMany('ApprovalStep', 'capexRequest')
  approvalSteps!: ApprovalStep[];

  @OneToMany('CapexComment', 'capexRequest')
  comments!: CapexComment[];

  @OneToMany('BudgetLineUsage', 'capexRequest')
  budgetUsages!: BudgetLineUsage[];

  @CreateDateColumn()
  createdAt!: Date;

  @UpdateDateColumn()
  updatedAt!: Date;
}
