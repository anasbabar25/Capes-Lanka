import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';
import { Budget } from '../budgets/budget.entity.js';
import { Department } from '../organization/department.entity.js';
import { User } from '../users/user.entity.js';
import { SeedService } from './seed.service.js';

@Module({
  imports: [TypeOrmModule.forFeature([Department, User, Budget])],
  providers: [SeedService],
})
export class SeedModule {}
