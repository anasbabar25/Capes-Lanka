export type BudgetType = "annual" | "strategic";

export type Budget = {
  id: number;
  referenceCode: string;
  description: string;
  budgetType: BudgetType;
  departmentCode: string;
  financialYear: string;
  totalAmount: string;
  reservedAmount: string;
  utilizedAmount: string;
  remainingAmount: number;
  underProgressAmount: number;
  isFrozen: boolean;
  department?: {
    departmentName: string;
  } | null;
};

export type BudgetUploadResult = {
  importedCount: number;
  budgets: Budget[];
};
