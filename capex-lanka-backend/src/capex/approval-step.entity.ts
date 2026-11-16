import {
  Column,
  CreateDateColumn,
  Entity,
  JoinColumn,
  ManyToOne,
  PrimaryGeneratedColumn,
  UpdateDateColumn,
} from 'typeorm';
import { User } from '../users/user.entity.js';
import { UserRole } from '../users/user-role.enum.js';
import type { CapexRequest } from './capex.entity.js';
import { ApprovalStepStatus } from './capex.enums.js';

@Entity('approval_steps')
export class ApprovalStep {
  @PrimaryGeneratedColumn()
  id!: number;

  @ManyToOne('CapexRequest', 'approvalSteps', {
    onDelete: 'CASCADE',
  })
  @JoinColumn({ name: 'capexRequestId' })
  capexRequest!: CapexRequest;

  @Column()
  capexRequestId!: number;

  @Column()
  sequenceNumber!: number;

  @Column({ type: 'varchar', length: 64 })
  approverRole!: UserRole;

  @ManyToOne(() => User, { eager: true, nullable: true })
  @JoinColumn({ name: 'assignedUserId' })
  assignedUser!: User | null;

  @Column({ nullable: true })
  assignedUserId!: number | null;

  @Column({ type: 'varchar', length: 32, default: ApprovalStepStatus.WAITING })
  stepStatus!: ApprovalStepStatus;

  @Column({ type: 'text', nullable: true })
  decisionComments!: string | null;

  @Column({ type: 'datetime', nullable: true })
  decidedAt!: Date | null;

  @ManyToOne(() => User, { nullable: true })
  @JoinColumn({ name: 'decidedByUserId' })
  decidedBy!: User | null;

  @Column({ nullable: true })
  decidedByUserId!: number | null;

  @CreateDateColumn()
  createdAt!: Date;

  @UpdateDateColumn()
  updatedAt!: Date;
}
