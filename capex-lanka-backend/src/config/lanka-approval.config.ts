import { UserRole } from '../users/user-role.enum.js';

/** Approval roles used on the Packages Lanka site (matches legacy tbldepts approvers). */
export const LANKA_APPROVAL_ROLES: UserRole[] = [
  UserRole.HOD,
  UserRole.FINANCIAL_CONTROLLER,
  UserRole.MANAGING_DIRECTOR,
  UserRole.INVENTORY,
];

export function isLankaApprovalRole(role: string): role is UserRole {
  return LANKA_APPROVAL_ROLES.includes(role as UserRole);
}

export function sortByLankaApprovalOrder<T extends { approverRole: UserRole | string }>(
  steps: T[],
): T[] {
  const order = new Map(LANKA_APPROVAL_ROLES.map((role, index) => [role, index]));
  return [...steps].sort(
    (left, right) =>
      (order.get(left.approverRole as UserRole) ?? 99) -
      (order.get(right.approverRole as UserRole) ?? 99),
  );
}
