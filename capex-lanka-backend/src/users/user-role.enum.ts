export enum UserRole {
  ORIGINATOR = 'originator',
  HOD = 'hod',
  BUSINESS_CONTROLLER = 'business-controller',
  BUM = 'bum',
  HEAD_OF_PACKAGING = 'head-of-packaging',
  HEAD_OF_ENGINEERING = 'head-of-engineering',
  HEAD_OF_CONSUMER_DIVISION = 'head-of-consumer-division',
  GROUP_HEAD_IT = 'group-head-it',
  GROUP_HEAD_HR = 'group-head-hr',
  GROUP_HEAD_SUPPLY_CHAIN = 'group-head-supply-chain',
  FINANCIAL_CONTROLLER = 'financial-controller',
  CFO = 'cfo',
  MANAGING_DIRECTOR = 'managing-director',
  INVENTORY = 'inventory',
  ERP = 'erp',
  SUPPLY_CHAIN = 'supply-chain',
  ADMIN = 'admin',
}

export const USER_ROLE_LABELS: Record<UserRole, string> = {
  [UserRole.ORIGINATOR]: 'Originator',
  [UserRole.HOD]: 'Head of Department',
  [UserRole.BUSINESS_CONTROLLER]: 'Business Controller',
  [UserRole.BUM]: 'Business Unit Manager',
  [UserRole.HEAD_OF_PACKAGING]: 'Head of Packaging',
  [UserRole.HEAD_OF_ENGINEERING]: 'Head of Engineering',
  [UserRole.HEAD_OF_CONSUMER_DIVISION]: 'Head of Consumer Division',
  [UserRole.GROUP_HEAD_IT]: 'Group Head of IT',
  [UserRole.GROUP_HEAD_HR]: 'Group Head of HR',
  [UserRole.GROUP_HEAD_SUPPLY_CHAIN]: 'Group Head of Supply Chain',
  [UserRole.FINANCIAL_CONTROLLER]: 'Financial Controller',
  [UserRole.CFO]: 'Chief Financial Officer',
  [UserRole.MANAGING_DIRECTOR]: 'Managing Director',
  [UserRole.INVENTORY]: 'Inventory',
  [UserRole.ERP]: 'ERP',
  [UserRole.SUPPLY_CHAIN]: 'Supply Chain',
  [UserRole.ADMIN]: 'Administrator',
};

export const UNIT_APPROVER_ROLES: UserRole[] = [
  UserRole.HOD,
  UserRole.BUSINESS_CONTROLLER,
  UserRole.BUM,
];

export const FUNCTIONAL_HEAD_ROLES: UserRole[] = [
  UserRole.HEAD_OF_PACKAGING,
  UserRole.HEAD_OF_ENGINEERING,
  UserRole.HEAD_OF_CONSUMER_DIVISION,
  UserRole.GROUP_HEAD_IT,
  UserRole.GROUP_HEAD_HR,
  UserRole.GROUP_HEAD_SUPPLY_CHAIN,
];

export const EXECUTION_ROLES: UserRole[] = [
  UserRole.INVENTORY,
  UserRole.ERP,
  UserRole.SUPPLY_CHAIN,
];
