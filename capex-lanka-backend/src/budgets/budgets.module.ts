import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';
import { AuthModule } from '../auth/auth.module.js';
import { Department } from '../organization/department.entity.js';
import { BudgetLineUsage } from './budget-line-usage.entity.js';
import { Budget } from './budget.entity.js';
import { BudgetsController } from './budgets.controller.js';
import { BudgetsService } from './budgets.service.js';

@Module({
  imports: [TypeOrmModule.forFeature([Budget, BudgetLineUsage, Department]), AuthModule],
  controllers: [BudgetsController],
  providers: [BudgetsService],
  exports: [BudgetsService, TypeOrmModule],
})
export class BudgetsModule {}
