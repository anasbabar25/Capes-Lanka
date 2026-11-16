import {
  Column,
  CreateDateColumn,
  Entity,
  JoinColumn,
  ManyToOne,
  PrimaryGeneratedColumn,
  UpdateDateColumn,
} from 'typeorm';
import { Department } from '../organization/department.entity.js';
import { BudgetType } from './budget.enums.js';

@Entity('budget_lines')
export class Budget {
  @PrimaryGeneratedColumn()
  id!: number;

  @Column({ unique: true })
  referenceCode!: string;

  @Column()
  description!: string;

  @Column({ type: 'varchar', length: 32 })
  budgetType!: BudgetType;

  @Column({ length: 32 })
  departmentCode!: string;

  @ManyToOne(() => Department, { eager: true, nullable: true })
  @JoinColumn({ name: 'departmentId' })
  department!: Department | null;

  @Column({ nullable: true })
  departmentId!: number | null;

  @Column({ length: 16, default: '2026' })
  financialYear!: string;

  @Column({ type: 'decimal', precision: 14, scale: 2, default: 0 })
  totalAmount!: string;

  @Column({ type: 'decimal', precision: 14, scale: 2, default: 0 })
  reservedAmount!: string;

  @Column({ type: 'decimal', precision: 14, scale: 2, default: 0 })
  utilizedAmount!: string;

  @Column({ default: false })
  isFrozen!: boolean;

  @CreateDateColumn()
  createdAt!: Date;

  @UpdateDateColumn()
  updatedAt!: Date;
}
