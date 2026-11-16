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
import { UserRole } from './user-role.enum.js';

@Entity('users')
export class User {
  @PrimaryGeneratedColumn()
  id!: number;

  @Column({ unique: true })
  username!: string;

  @Column({ select: false })
  password!: string;

  @Column({ unique: true })
  email!: string;

  @Column()
  displayName!: string;

  @Column({ type: 'varchar', length: 64 })
  role!: UserRole;

  @ManyToOne(() => Department, { eager: true, nullable: true })
  @JoinColumn({ name: 'departmentId' })
  department!: Department | null;

  @Column({ nullable: true })
  departmentId!: number | null;

  @ManyToOne(() => User, { nullable: true })
  @JoinColumn({ name: 'reportsToUserId' })
  reportsTo!: User | null;

  @Column({ nullable: true })
  reportsToUserId!: number | null;

  @Column({ default: true })
  isActive!: boolean;

  @CreateDateColumn()
  createdAt!: Date;

  @UpdateDateColumn()
  updatedAt!: Date;
}
