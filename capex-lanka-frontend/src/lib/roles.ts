import { filterLankaApprovalSteps, LANKA_APPROVAL_ROLES } from "@/lib/lanka-approval";
import type { UserRole } from "@/types/auth";

export const ROLE_LABELS: Record<UserRole, string> = {
  originator: "Originator",
  hod: "Head of Department",
  "business-controller": "Business Controller",
  bum: "Business Unit Manager",
  "head-of-packaging": "Head of Packaging",
  "head-of-engineering": "Head of Engineering",
  "head-of-consumer-division": "Head of Consumer Division",
  "group-head-it": "Group Head of IT",
  "group-head-hr": "Group Head of HR",
  "group-head-supply-chain": "Group Head of Supply Chain",
  "financial-controller": "Financial Controller",
  cfo: "Chief Financial Officer",
  "managing-director": "Managing Director",
  inventory: "Inventory",
  erp: "ERP",
  "supply-chain": "Supply Chain",
  admin: "Administrator",
};

export function formatRole(role: string | null | undefined, fallback = "—") {
  if (!role) return fallback;
  return ROLE_LABELS[role as UserRole] ?? role.replace(/-/g, " ");
}

export function formatPendingStages(
  approvalSteps: { approverRole: string; stepStatus: string }[] | undefined,
  currentStage: string | null | undefined,
) {
  const pendingRoles =
    filterLankaApprovalSteps(approvalSteps ?? [])
      .filter((step) => step.stepStatus === "pending")
      .map((step) => formatRole(step.approverRole)) ?? [];

  if (pendingRoles.length > 0) {
    return pendingRoles.join(", ");
  }

  return currentStage ? formatRole(currentStage) : "Completed";
}

export const CAPEX_STATUS_FILTER_OPTIONS = [
  { value: "", label: "All statuses" },
  { value: "pending", label: "Pending" },
  { value: "approved", label: "Approved" },
  { value: "rejected", label: "Rejected" },
  { value: "returned", label: "Returned" },
] as const;

export const CAPEX_STAGE_FILTER_OPTIONS = [
  { value: "", label: "All stages" },
  { value: "completed", label: "Completed" },
  ...LANKA_APPROVAL_ROLES.map((role) => ({
    value: role,
    label: ROLE_LABELS[role],
  })),
];

export function canCreateCapex(role: UserRole) {
  return role === "originator" || role === "admin";
}

export function canManageBudgets(role: UserRole) {
  return (
    role === "business-controller" ||
    role === "financial-controller" ||
    role === "inventory" ||
    role === "admin"
  );
}

export function canApproveCapex(role: UserRole) {
  return role !== "originator";
}

export function formatMoney(value: string | number) {
  const amount = typeof value === "string" ? parseFloat(value) : value;
  return new Intl.NumberFormat("en-LK", {
    style: "currency",
    currency: "LKR",
    maximumFractionDigits: 0,
  }).format(Number.isFinite(amount) ? amount : 0);
}

export function formatDate(value: string) {
  return new Intl.DateTimeFormat("en-GB", {
    day: "2-digit",
    month: "short",
    year: "numeric",
  }).format(new Date(value));
}
