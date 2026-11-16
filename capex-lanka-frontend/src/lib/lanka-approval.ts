import type { UserRole } from "@/types/auth";

/** Approval roles on the Packages Lanka site (HOD → COA → MD → Inventory). */
export const LANKA_APPROVAL_ROLES: UserRole[] = [
  "hod",
  "financial-controller",
  "managing-director",
  "inventory",
];

const lankaRoleSet = new Set<string>(LANKA_APPROVAL_ROLES);

export function isLankaApprovalRole(role: string) {
  return lankaRoleSet.has(role);
}

export function filterLankaApprovalSteps<T extends { approverRole: string }>(steps: T[]) {
  return steps.filter((step) => isLankaApprovalRole(step.approverRole));
}

export function sortByLankaApprovalOrder<T extends { approverRole: string }>(steps: T[]) {
  const order = new Map(LANKA_APPROVAL_ROLES.map((role, index) => [role, index]));
  return [...steps].sort(
    (left, right) =>
      (order.get(left.approverRole as UserRole) ?? 99) -
      (order.get(right.approverRole as UserRole) ?? 99),
  );
}

