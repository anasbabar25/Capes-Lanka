export type UserRole =
  | "originator"
  | "hod"
  | "business-controller"
  | "bum"
  | "head-of-packaging"
  | "head-of-engineering"
  | "head-of-consumer-division"
  | "group-head-it"
  | "group-head-hr"
  | "group-head-supply-chain"
  | "financial-controller"
  | "cfo"
  | "managing-director"
  | "inventory"
  | "erp"
  | "supply-chain"
  | "admin";

export type AuthDepartment = {
  id: number;
  code: string;
  name: string;
  allowsUnbudgetedRequests: boolean;
  allowsBudgetVirement: boolean;
  isBudgetFrozen: boolean;
};

export type AuthUser = {
  id: number;
  username: string;
  role: UserRole;
  displayName: string;
  loginAccountName?: string;
  roleLabel: string;
  email: string;
  department: AuthDepartment | null;
};

export type DirectoryUser = AuthUser;

export type LoginResponse = {
  accessToken: string;
  user: AuthUser;
};
