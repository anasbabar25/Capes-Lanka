import { registerAs } from '@nestjs/config';

/** Department codes visible when SITE_SCOPE=LANKA */
export const LANKA_DEPARTMENT_CODES = ['LANKA', 'CORP'] as const;

export default registerAs('site', () => ({
  scope: process.env.SITE_SCOPE ?? 'LANKA',
  isLankaOnly: (process.env.SITE_SCOPE ?? 'LANKA') === 'LANKA',
  lankaDepartmentCodes: [...LANKA_DEPARTMENT_CODES],
}));
