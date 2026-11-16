import {
  Body,
  Controller,
  Get,
  Param,
  ParseIntPipe,
  Post,
  Query,
  Req,
  UseGuards,
} from '@nestjs/common';
import { JwtAuthGuard } from '../auth/jwt-auth.guard.js';
import { Roles } from '../common/decorators/roles.decorator.js';
import { RolesGuard } from '../common/guards/roles.guard.js';
import type { AuthenticatedRequest } from '../auth/authenticated-request.type.js';
import { UserRole } from '../users/user-role.enum.js';
import { CapexService } from './capex.service.js';
import { CreateCapexDto } from './dto/create-capex.dto.js';
import { DecideCapexDto } from './dto/decide-capex.dto.js';

@Controller('capex')
@UseGuards(JwtAuthGuard, RolesGuard)
export class CapexController {
  constructor(private readonly capexService: CapexService) {}

  @Get()
  findAll(
    @Req() req: AuthenticatedRequest,
    @Query('page') page?: string,
    @Query('limit') limit?: string,
    @Query('search') search?: string,
    @Query('status') status?: string,
    @Query('currentStage') currentStage?: string,
  ) {
    return this.capexService.findAll(req.user, page, limit, {
      search,
      status,
      currentStage,
    });
  }

  @Get('stats')
  getStats(@Req() req: AuthenticatedRequest) {
    return this.capexService.getStats(req.user);
  }

  @Get('pending')
  findPending(@Req() req: AuthenticatedRequest) {
    return this.capexService.findPendingFor(req.user);
  }

  @Get(':id')
  findOne(@Param('id', ParseIntPipe) id: number) {
    return this.capexService.findOne(id);
  }

  @Post()
  @Roles(UserRole.ORIGINATOR, UserRole.ADMIN)
  create(@Body() dto: CreateCapexDto, @Req() req: AuthenticatedRequest) {
    return this.capexService.create(dto, req.user);
  }

  @Post(':id/decide')
  decide(
    @Param('id', ParseIntPipe) id: number,
    @Body() dto: DecideCapexDto,
    @Req() req: AuthenticatedRequest,
  ) {
    return this.capexService.decide(id, dto, req.user);
  }
}
