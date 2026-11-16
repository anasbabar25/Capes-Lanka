export enum BudgetedOption {
  YES = 'yes',
  STRATEGIC = 'strategic',
  NO = 'no',
}

export enum ReplacementExpansionOption {
  REPLACEMENT = 'replacement',
  EXPANSION = 'expansion',
}

export enum CapexCategory {
  BUILDING = 'building',
  ENTITLEMENTS = 'entitlements',
  HEAVY_VEHICLES = 'heavy-vehicles',
  IT_EQUIPMENTS = 'it-equipments',
  LAND = 'land',
  OTHER_EQUIPMENT = 'other-equipment',
  PLANT_AND_MACHINERY = 'plant-and-machinery',
}

export enum YesNoOption {
  YES = 'yes',
  NO = 'no',
}

export enum ApprovalStepStatus {
  WAITING = 'waiting',
  PENDING = 'pending',
  APPROVED = 'approved',
  REJECTED = 'rejected',
  SKIPPED = 'skipped',
}

export const APPROVAL_THRESHOLDS = {
  cfoAndManagingDirector: 500_000,
  financialControllerPaybackRequired: 1_000_000,
} as const;
