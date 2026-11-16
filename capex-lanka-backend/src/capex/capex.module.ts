import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';
import { AuthModule } from '../auth/auth.module.js';
import { BudgetsModule } from '../budgets/budgets.module.js';
import { UsersModule } from '../users/users.module.js';
import { ApprovalEngineService } from './approval-engine.service.js';
import { ApprovalStep } from './approval-step.entity.js';
import { CapexComment } from './capex-comment.entity.js';
import { CapexController } from './capex.controller.js';
import { CapexRequest } from './capex.entity.js';
import { CapexService } from './capex.service.js';

@Module({
  imports: [
    TypeOrmModule.forFeature([CapexRequest, ApprovalStep, CapexComment]),
    UsersModule,
    BudgetsModule,
    AuthModule,
  ],
  controllers: [CapexController],
  providers: [CapexService, ApprovalEngineService],
})
export class CapexModule {}
