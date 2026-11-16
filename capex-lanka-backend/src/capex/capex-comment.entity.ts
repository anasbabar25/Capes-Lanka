import {
  Column,
  CreateDateColumn,
  Entity,
  JoinColumn,
  ManyToOne,
  PrimaryGeneratedColumn,
} from 'typeorm';
import { User } from '../users/user.entity.js';
import type { CapexRequest } from './capex.entity.js';

@Entity('capex_comments')
export class CapexComment {
  @PrimaryGeneratedColumn()
  id!: number;

  @ManyToOne('CapexRequest', 'comments', {
    onDelete: 'CASCADE',
  })
  @JoinColumn({ name: 'capexRequestId' })
  capexRequest!: CapexRequest;

  @Column()
  capexRequestId!: number;

  @ManyToOne(() => User, { eager: true })
  @JoinColumn({ name: 'authorUserId' })
  author!: User;

  @Column()
  authorUserId!: number;

  @Column({ type: 'text' })
  message!: string;

  @CreateDateColumn()
  createdAt!: Date;
}
