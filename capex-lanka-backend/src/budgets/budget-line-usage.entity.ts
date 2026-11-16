import {
  Column,
  CreateDateColumn,
  Entity,
  JoinColumn,
  ManyToOne,
  PrimaryGeneratedColumn,
  UpdateDateColumn,
} from 'typeorm';
import type { CapexRequest } from '../capex/capex.entity.js';
import { Budget } from './budget.entity.js';
import { BudgetUsageStatus } from './budget.enums.js';

@Entity('budget_line_usages')
export class BudgetLineUsage {
  @PrimaryGeneratedColumn()
  id!: number;

  @ManyToOne('CapexRequest', 'budgetUsages', {
    onDelete: 'CASCADE',
  })
  @JoinColumn({ name: 'capexRequestId' })
  capexRequest!: CapexRequest;

  @Column()
  capexRequestId!: number;

  @ManyToOne(() => Budget, { eager: true })
  @JoinColumn({ name: 'budgetLineId' })
  budgetLine!: Budget;

  @Column()
  budgetLineId!: number;

  @Column({ type: 'decimal', precision: 14, scale: 2 })
  allocatedAmount!: string;

  @Column({ default: false })
  isPrimaryLine!: boolean;

  @Column({ type: 'varchar', length: 32, default: BudgetUsageStatus.RESERVED })
  usageStatus!: BudgetUsageStatus;

  @CreateDateColumn()
  createdAt!: Date;

  @UpdateDateColumn()
  updatedAt!: Date;
}
