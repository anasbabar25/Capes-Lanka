import {
  Column,
  CreateDateColumn,
  Entity,
  PrimaryGeneratedColumn,
  UpdateDateColumn,
} from 'typeorm';
import { UserRole } from '../users/user-role.enum.js';

@Entity('departments')
export class Department {
  @PrimaryGeneratedColumn()
  id!: number;

  @Column({ unique: true, length: 32 })
  departmentCode!: string;

  @Column()
  departmentName!: string;

  @Column({ type: 'varchar', length: 64 })
  functionalHeadRole!: UserRole;

  @Column({ default: true })
  allowsUnbudgetedRequests!: boolean;

  @Column({ default: true })
  allowsBudgetVirement!: boolean;

  @Column({ default: false })
  isBudgetFrozen!: boolean;

  @Column({ default: true })
  isActive!: boolean;

  @CreateDateColumn()
  createdAt!: Date;

  @UpdateDateColumn()
  updatedAt!: Date;
}
