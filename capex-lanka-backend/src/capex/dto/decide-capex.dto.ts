import { Type } from 'class-transformer';
import {
  IsEnum,
  IsNumber,
  IsOptional,
  IsString,
  Min,
  MinLength,
  ValidateIf,
} from 'class-validator';

export enum ApprovalDecision {
  APPROVE = 'approve',
  REJECT = 'reject',
  RETURN = 'return',
}

export class DecideCapexDto {
  @IsEnum(ApprovalDecision)
  decision!: ApprovalDecision;

  @IsString()
  @MinLength(3)
  comments!: string;

  @IsOptional()
  @IsString()
  paybackPeriod?: string;

  @IsOptional()
  @Type(() => Number)
  @IsNumber()
  @Min(0)
  internalRateOfReturn?: number;

  @ValidateIf((dto: DecideCapexDto) => dto.decision === ApprovalDecision.APPROVE)
  @IsOptional()
  @IsString()
  glAccountNumber?: string;

  @IsOptional()
  @IsString()
  internalOrderNumber?: string;

  @IsOptional()
  @IsString()
  capexFormNumber?: string;

  @IsOptional()
  @IsString()
  purchaseRequisitionNumber?: string;

  @IsOptional()
  @IsString()
  purchaseOrderNumber?: string;
}
