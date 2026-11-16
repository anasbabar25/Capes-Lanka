import {
  BadRequestException,
  Controller,
  Get,
  Post,
  Query,
  Req,
  UploadedFile,
  UseGuards,
  UseInterceptors,
} from '@nestjs/common';
import { FileInterceptor } from '@nestjs/platform-express';
import { JwtAuthGuard } from '../auth/jwt-auth.guard.js';
import { Roles } from '../common/decorators/roles.decorator.js';
import { RolesGuard } from '../common/guards/roles.guard.js';
import type { AuthenticatedRequest } from '../auth/authenticated-request.type.js';
import { UserRole } from '../users/user-role.enum.js';
import { BudgetType } from './budget.enums.js';
import { BudgetsService } from './budgets.service.js';

@Controller('budgets')
@UseGuards(JwtAuthGuard, RolesGuard)
export class BudgetsController {
  constructor(private readonly budgetsService: BudgetsService) {}

  @Get()
  findAll() {
    return this.budgetsService.findAll();
  }

  @Get('available')
  findAvailable(
    @Req() req: AuthenticatedRequest,
    @Query('type') type?: BudgetType,
  ) {
    return this.budgetsService.findAvailable(req.user, type);
  }

  @Post('upload')
  @Roles(
    UserRole.BUSINESS_CONTROLLER,
    UserRole.FINANCIAL_CONTROLLER,
    UserRole.INVENTORY,
    UserRole.ADMIN,
  )
  @UseInterceptors(FileInterceptor('file', { limits: { fileSize: 2 * 1024 * 1024 } }))
  upload(@UploadedFile() file?: { buffer: Buffer; originalname: string }) {
    if (!file?.buffer) {
      throw new BadRequestException('Upload a CSV file in the "file" field');
    }
    if (!file.originalname.toLowerCase().endsWith('.csv')) {
      throw new BadRequestException('Only CSV files are supported');
    }
    return this.budgetsService.uploadCsv(file.buffer);
  }
}
