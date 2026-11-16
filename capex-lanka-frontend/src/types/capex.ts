export type CapexStatus = "pending" | "approved" | "rejected" | "returned";

export type CapexStats = {
  total: number;
  approved: number;
  pending: number;
  rejected: number;
  returned: number;
};

export type PaginatedResponse<T> = {
  data: T[];
  total: number;
  page: number;
  limit: number;
  totalPages: number;
};

export type ApprovalStep = {
  id: number;
  sequenceNumber: number;
  approverRole: string;
  assignedUser: { id: number; displayName: string; role: string } | null;
  decidedBy: { id: number; displayName: string; role: string } | null;
  stepStatus: "waiting" | "pending" | "approved" | "rejected" | "skipped";
  decisionComments: string | null;
  decidedAt: string | null;
};

export type CapexComment = {
  id: number;
  message: string;
  createdAt: string;
  author: { displayName: string; role: string };
};

export type BudgetUsage = {
  id: number;
  allocatedAmount: string;
  isPrimaryLine: boolean;
  usageStatus: string;
  budgetLine: {
    referenceCode: string;
    description: string;
  };
};

export type CapexRequest = {
  id: number;
  referenceNo: string;
  costCenter: string;
  originatingDepartment: {
    departmentCode: string;
    departmentName: string;
  };
  budgeted: string;
  expectedCompletionDate: string;
  replacementExpansion: string;
  category: string;
  detailOfProposal: string;
  desiredAssetNameSap: string;
  inHouseAvailability: string;
  enteredByEmail: string;
  extensionNumber: string;
  localCost: string;
  importedCost: string;
  currencyCode: string | null;
  foreignCurrencyAmount: string;
  exchangeRate: string;
  localCustomsDuty: string;
  importedCustomsDuty: string;
  localOtherCost: string;
  importedOtherCost: string;
  localGst: string;
  importedGst: string;
  totalAmount: string;
  paybackPeriod: string | null;
  internalRateOfReturn: string | null;
  glAccountNumber: string | null;
  internalOrderNumber: string | null;
  capexFormNumber: string | null;
  purchaseRequisitionNumber: string | null;
  purchaseOrderNumber: string | null;
  status: CapexStatus;
  currentStage: string | null;
  currentApprover: { displayName: string; role: string } | null;
  createdAt: string;
  createdBy: {
    id: number;
    displayName: string;
    role: string;
  };
  approvalSteps?: ApprovalStep[];
  comments?: CapexComment[];
  budgetUsages?: BudgetUsage[];
};
