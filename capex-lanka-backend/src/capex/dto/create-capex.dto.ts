import { Type } from 'class-transformer';
import {
  IsArray,
  IsDateString,
  IsEmail,
  IsEnum,
  IsInt,
  IsNotEmpty,
  IsNumber,
  IsOptional,
  IsString,
  Min,
  MinLength,
  ValidateIf,
} from 'class-validator';
import {
  BudgetedOption,
  CapexCategory,
  ReplacementExpansionOption,
  YesNoOption,
} from '../capex.enums.js';

export class CreateCapexDto {
  @IsString()
  @IsNotEmpty()
  costCenter!: string;

  @IsEnum(BudgetedOption)
  budgeted!: BudgetedOption;

  @ValidateIf((dto: CreateCapexDto) =>
    [BudgetedOption.YES, BudgetedOption.STRATEGIC].includes(dto.budgeted),
  )
  @Type(() => Number)
  @IsInt()
  primaryBudgetLineId?: number;

  @IsOptional()
  @IsArray()
  @IsInt({ each: true })
  additionalBudgetLineIds?: number[];

  @IsDateString()
  expectedCompletionDate!: string;

  @IsEnum(ReplacementExpansionOption)
  replacementExpansion!: ReplacementExpansionOption;

  @IsEnum(CapexCategory)
  category!: CapexCategory;

  @IsString()
  @MinLength(10)
  detailOfProposal!: string;

  @IsString()
  @IsNotEmpty()
  desiredAssetNameSap!: string;

  @IsEnum(YesNoOption)
  inHouseAvailability!: YesNoOption;

  @IsEmail()
  enteredByEmail!: string;

  @IsString()
  @IsNotEmpty()
  extensionNumber!: string;

  @IsOptional()
  @Type(() => Number)
  @IsNumber()
  @Min(0)
  localCost?: number;

  @IsOptional()
  @Type(() => Number)
  @IsNumber()
  @Min(0)
  importedCost?: number;

  @IsOptional()
  @IsString()
  currencyCode?: string;

  @IsOptional()
  @Type(() => Number)
  @IsNumber()
  @Min(0)
  foreignCurrencyAmount?: number;

  @IsOptional()
  @Type(() => Number)
  @IsNumber()
  @Min(0)
  exchangeRate?: number;

  @IsOptional()
  @Type(() => Number)
  @IsNumber()
  @Min(0)
  localCustomsDuty?: number;

  @IsOptional()
  @Type(() => Number)
  @IsNumber()
  @Min(0)
  importedCustomsDuty?: number;

  @IsOptional()
  @Type(() => Number)
  @IsNumber()
  @Min(0)
  localOtherCost?: number;

  @IsOptional()
  @Type(() => Number)
  @IsNumber()
  @Min(0)
  importedOtherCost?: number;

  @IsOptional()
  @Type(() => Number)
  @IsNumber()
  @Min(0)
  localGst?: number;

  @IsOptional()
  @Type(() => Number)
  @IsNumber()
  @Min(0)
  importedGst?: number;
}
