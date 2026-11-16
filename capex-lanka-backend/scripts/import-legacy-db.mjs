import { createConnection } from 'mysql2/promise';
import bcrypt from 'bcryptjs';
import { readFileSync, existsSync } from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const projectRoot = path.resolve(__dirname, '..');
const repoRoot = path.resolve(projectRoot, '..');

function loadEnv() {
  const envPath = path.join(projectRoot, '.env');
  if (!existsSync(envPath)) {
    throw new Error('.env file not found in capex-lanka-backend');
  }
  return Object.fromEntries(
    readFileSync(envPath, 'utf8')
      .split('\n')
      .filter((line) => line && !line.startsWith('#'))
      .map((line) => {
        const index = line.indexOf('=');
        return [line.slice(0, index).trim(), line.slice(index + 1).trim()];
      }),
  );
}

function sanitizeDate(value, fallback = '2024-01-01') {
  if (!value || value === '0000-00-00' || value === '0000-00-00 00:00:00') {
    return fallback;
  }

  const raw = String(value).trim();
  if (/^\d{4}-\d{2}-\d{2}/.test(raw)) {
    return raw.slice(0, 10);
  }

  const parsed = new Date(raw);
  if (!Number.isNaN(parsed.getTime())) {
    return parsed.toISOString().slice(0, 10);
  }

  return fallback;
}

function toDecimal(value) {
  const num = Number(value ?? 0);
  return Number.isFinite(num) ? num.toFixed(2) : '0.00';
}

function sanitizeCurrency(value) {
  const raw = String(value ?? '').trim();
  if (!raw || raw === '0.00' || raw === '0') return null;
  const code = raw.toUpperCase().replace(/[^A-Z]/g, '').slice(0, 8);
  return code.length > 0 ? code : null;
}

/** Lanka site: map legacy accounts to LANKA (plant) or CORP (executives). */
function deptCodeFromName(name) {
  const upper = String(name ?? '').toUpperCase();
  if (['COA', 'INV', 'MD', 'CFO', 'HOP', 'HOE', 'HCD', 'GHIT', 'GHHR', 'ERP'].includes(upper)) {
    return 'CORP';
  }
  if (upper.startsWith('LANKA')) return 'LANKA';
  return 'LANKA';
}

function isLankaLegacyAccount(row) {
  const name = String(row.dName ?? '').toUpperCase();
  return (
    name.startsWith('LANKA') ||
    ['COA', 'INV', 'MD'].includes(name)
  );
}

function isLankaBudgetRow(row) {
  const mainDept = String(row.bMDept ?? row.sbMDept ?? '').trim().toLowerCase();
  return mainDept === 'lanka' || mainDept === '';
}

function roleFromLegacyName(name, tId) {
  const upper = String(name ?? '').toUpperCase();
  if (upper === 'HOP') return 'head-of-packaging';
  if (upper === 'HOE') return 'head-of-engineering';
  if (upper === 'HCD') return 'head-of-consumer-division';
  if (upper === 'GHIT') return 'group-head-it';
  if (upper === 'GHHR') return 'group-head-hr';
  if (upper === 'COA') return 'financial-controller';
  if (upper === 'CFO') return 'cfo';
  if (upper === 'MD') return 'managing-director';
  if (upper === 'INV') return 'inventory';
  if (upper === 'ERP' || upper === 'ERP-USER') return 'erp';
  if (upper.includes('-USER')) return 'originator';
  if (upper.includes('-BC')) return 'business-controller';
  if (upper.includes('-BUM')) return 'bum';
  if (upper === 'LANKA-USER') return 'originator';
  if (upper === 'LANKA') return 'hod';
  if (Number(tId) === 2) return 'business-controller';
  if (Number(tId) === 1 && !upper.includes('-')) return 'bum';
  if (Number(tId) === 3) return 'hod';
  return 'originator';
}

function mapCategory(categoryId, categoryName) {
  const byId = {
    1: 'land',
    2: 'building',
    3: 'plant-and-machinery',
    4: 'other-equipment',
    5: 'heavy-vehicles',
    8: 'entitlements',
    9: 'it-equipments',
  };
  if (byId[categoryId]) return byId[categoryId];

  const normalized = String(categoryName ?? '').toLowerCase();
  if (normalized.includes('land')) return 'land';
  if (normalized.includes('building')) return 'building';
  if (normalized.includes('plant')) return 'plant-and-machinery';
  if (normalized.includes('vehicle')) return 'heavy-vehicles';
  if (normalized.includes('entitlement')) return 'entitlements';
  if (normalized.includes('it')) return 'it-equipments';
  return 'other-equipment';
}

function mapBudgeted(value) {
  if (String(value) === '3') return 'strategic';
  if (String(value) === '4') return 'no';
  return 'yes';
}

function mapYesNo(value) {
  return String(value) === '2' ? 'yes' : 'no';
}

function mapReplacement(value) {
  return String(value ?? '').toLowerCase().includes('expansion')
    ? 'expansion'
    : 'replacement';
}

function mapApprovalStatus(flag) {
  if (Number(flag) === 2) return 'approved';
  if (Number(flag) === 3) return 'rejected';
  if (Number(flag) === 1) return 'pending';
  return 'waiting';
}

function deriveCapexStatus(cp) {
  const flags = [
    cp.cpHOD_Flag,
    cp.cpBC_Flag,
    cp.cpBUM_Flag,
    cp.cpIA_FLAG,
    cp.cpINV_Flag,
    cp.cpERP_Flag,
    cp.cp_SP_Flag,
  ].map(Number);
  if (flags.includes(3)) return 'rejected';
  if (Number(cp.cp_SP_Flag) === 2 || (Number(cp.cpERP_Flag) === 2 && Number(cp.cpINV_Flag) === 2)) {
    return 'approved';
  }
  if (Number(cp.cpINV_Flag) === 2) return 'approved';
  return 'pending';
}

function deriveCurrentStage(cp) {
  if (Number(cp.cpHOD_Flag) === 1) return 'hod';
  if (Number(cp.cpBC_Flag) === 1) return 'business-controller';
  if (Number(cp.cpBUM_Flag) === 1) return 'bum';
  if (Number(cp.cpIA_FLAG) === 1) return 'financial-controller';
  if (Number(cp.cpINV_Flag) === 1) return 'inventory';
  if (Number(cp.cpERP_Flag) === 1) return 'erp';
  if (Number(cp.cp_SP_Flag) === 1) return 'supply-chain';
  return null;
}

/** Packages Lanka approval chain: HOD → COA → MD → Inventory */
const LANKA_APPROVAL_ROLES = [
  'hod',
  'financial-controller',
  'managing-director',
  'inventory',
];
const ROLE_ORDER = [...LANKA_APPROVAL_ROLES];
const STATUS_PRIORITY = {
  rejected: 4,
  approved: 3,
  pending: 2,
  waiting: 1,
  skipped: 0,
};

function roleOrderIndex(role) {
  const index = ROLE_ORDER.indexOf(role);
  return index === -1 ? ROLE_ORDER.length + 1 : index;
}

function planLankaApprovalChain(userIdByRole) {
  return LANKA_APPROVAL_ROLES.map((role) => ({
    role,
    userId: userIdByRole.get(role) ?? null,
  }));
}

function enrichPlanWithLegacyRoles(planned, evidenceByRole, userIdByRole) {
  const lankaRoleSet = new Set(LANKA_APPROVAL_ROLES);
  const plannedRoles = new Set(planned.map((step) => step.role));
  const extras = [...evidenceByRole.keys()].filter(
    (role) => !plannedRoles.has(role) && lankaRoleSet.has(role),
  );
  const merged = [...planned];

  for (const role of extras) {
    merged.push({
      role,
      userId: evidenceByRole.get(role)?.assigneeUserId ?? userIdByRole.get(role) ?? null,
    });
  }

  merged.sort((left, right) => roleOrderIndex(left.role) - roleOrderIndex(right.role));
  return merged;
}

function collectLegacyEvidence(cp, approvals, legacyUsersById, userIdByLegacyDeptId) {
  const byRole = new Map();

  function setEvidence(role, status, date, assigneeUserId) {
    const existing = byRole.get(role);
    if (!existing || STATUS_PRIORITY[status] > STATUS_PRIORITY[existing.status]) {
      byRole.set(role, {
        status,
        date: status === 'pending' ? null : `${sanitizeDate(date)} 00:00:00`,
        assigneeUserId,
      });
    }
  }

  const flagMap = [
    ['hod', cp.cpHOD_Flag, cp.cpHOD_Date, cp.cpHOD],
    ['financial-controller', cp.cpIA_FLAG, cp.cpIA_Date, null],
    ['inventory', cp.cpINV_Flag, cp.cpINV_Date, null],
  ];

  for (const [role, flag, date, legacyAssigneeId] of flagMap) {
    const status = mapApprovalStatus(flag);
    if (status === 'waiting') continue;
    const assigneeUserId = legacyAssigneeId
      ? userIdByLegacyDeptId.get(Number(legacyAssigneeId)) ?? null
      : null;
    setEvidence(role, status, date, assigneeUserId);
  }

  for (const approval of approvals) {
    const legacyUser = legacyUsersById.get(Number(approval.cpAID));
    const role = legacyUser
      ? roleFromLegacyName(legacyUser.dName, legacyUser.tID)
      : 'financial-controller';
    if (!LANKA_APPROVAL_ROLES.includes(role)) continue;
    const status =
      Number(approval.cpAStatus) === 2
        ? 'approved'
        : Number(approval.cpAStatus) === 3
          ? 'rejected'
          : 'pending';
    const assigneeUserId = userIdByLegacyDeptId.get(Number(approval.cpAID)) ?? null;
    setEvidence(role, status, approval.cpADate, assigneeUserId);
  }

  return byRole;
}

function resolveStepStatuses(planned, evidenceByRole, capexStatus) {
  const hasRejected = [...evidenceByRole.values()].some((entry) => entry.status === 'rejected');

  return planned.map(({ role, userId }, index) => {
    const evidence = evidenceByRole.get(role);

    if (evidence) {
      return {
        role,
        assignedUserId: evidence.assigneeUserId ?? userId,
        stepStatus: evidence.status,
        decidedAt: evidence.date,
        decidedByUserId:
          evidence.status === 'pending' ? null : evidence.assigneeUserId ?? userId,
      };
    }

    if (hasRejected || capexStatus === 'rejected' || capexStatus === 'returned') {
      return {
        role,
        assignedUserId: userId,
        stepStatus: 'skipped',
        decidedAt: null,
        decidedByUserId: null,
      };
    }

    if (capexStatus === 'approved') {
      return {
        role,
        assignedUserId: userId,
        stepStatus: 'approved',
        decidedAt: null,
        decidedByUserId: userId,
      };
    }

    const priorRoles = planned.slice(0, index).map((step) => step.role);
    const allPriorApproved = priorRoles.every((priorRole) => {
      const prior = evidenceByRole.get(priorRole);
      return prior?.status === 'approved';
    });
    const anyPending = [...evidenceByRole.values()].some((entry) => entry.status === 'pending');

    return {
      role,
      assignedUserId: userId,
      stepStatus: !anyPending && allPriorApproved ? 'pending' : 'waiting',
      decidedAt: null,
      decidedByUserId: null,
    };
  });
}

async function insertApprovalChain(connection, capexRequestId, steps) {
  let sequence = 1;
  for (const step of steps) {
    await connection.query(
      `INSERT INTO approval_steps
        (capexRequestId, sequenceNumber, approverRole, assignedUserId, stepStatus, decisionComments, decidedAt, decidedByUserId, createdAt, updatedAt)
       VALUES (?, ?, ?, ?, ?, NULL, ?, ?, NOW(), NOW())`,
      [
        capexRequestId,
        sequence++,
        step.role,
        step.assignedUserId,
        step.stepStatus,
        step.stepStatus === 'pending' ? null : step.decidedAt,
        step.stepStatus === 'pending' ? null : step.decidedByUserId,
      ],
    );
  }
}

async function buildUserMaps(connection) {
  const [rows] = await connection.query(
    'SELECT id, role, reportsToUserId FROM users WHERE isActive = 1',
  );
  const usersById = new Map(
    rows.map((row) => [
      Number(row.id),
      {
        id: Number(row.id),
        role: row.role,
        reportsToUserId: row.reportsToUserId ? Number(row.reportsToUserId) : null,
      },
    ]),
  );
  const userIdByRole = new Map();
  for (const row of rows) {
    if (!userIdByRole.has(row.role)) {
      userIdByRole.set(row.role, Number(row.id));
    }
  }
  return { usersById, userIdByRole };
}

/** Lanka-only departments. Old PHP allowed unbudgeted + virement for bMDept=Lanka. */
const DEPARTMENT_DEFAULTS = {
  LANKA: {
    departmentName: 'Packages Lanka',
    functionalHeadRole: 'head-of-packaging',
    allowsUnbudgetedRequests: true,
    allowsBudgetVirement: true,
  },
  CORP: {
    departmentName: 'Corporate / Executives',
    functionalHeadRole: 'head-of-packaging',
    allowsUnbudgetedRequests: true,
    allowsBudgetVirement: true,
  },
};

async function ensureLegacyTables(connection, sqlPath) {
  const [tables] = await connection.query("SHOW TABLES LIKE 'tblcp'");
  if (tables.length > 0) {
    console.log('Legacy tables already present, skipping SQL import.');
    return;
  }

  if (!existsSync(sqlPath)) {
    throw new Error(`Legacy SQL dump not found at ${sqlPath}`);
  }

  console.log(`Importing legacy SQL dump from ${sqlPath} ...`);
  const sql = readFileSync(sqlPath, 'utf8');
  await connection.query({ sql, multipleStatements: true });
  console.log('Legacy SQL import complete.');
}

async function clearNewTables(connection) {
  await connection.query('SET FOREIGN_KEY_CHECKS = 0');
  for (const table of [
    'approval_steps',
    'budget_line_usages',
    'capex_comments',
    'capex_requests',
    'budget_lines',
    'budgets',
    'users',
    'departments',
  ]) {
    try {
      await connection.query(`TRUNCATE TABLE \`${table}\``);
    } catch {
      // table may not exist yet; TypeORM will create on next app start
    }
  }
  await connection.query('SET FOREIGN_KEY_CHECKS = 1');
}

async function migrateDepartments(connection) {
  const departmentIdByCode = new Map();
  for (const code of ['CORP', 'LANKA']) {
    const defaults = DEPARTMENT_DEFAULTS[code] ?? DEPARTMENT_DEFAULTS.CORP;
    const [result] = await connection.query(
      `INSERT INTO departments
        (departmentCode, departmentName, functionalHeadRole, allowsUnbudgetedRequests, allowsBudgetVirement, isBudgetFrozen, isActive, createdAt, updatedAt)
       VALUES (?, ?, ?, ?, ?, 0, 1, NOW(), NOW())`,
      [
        code,
        defaults.departmentName,
        defaults.functionalHeadRole,
        defaults.allowsUnbudgetedRequests ? 1 : 0,
        defaults.allowsBudgetVirement ? 1 : 0,
      ],
    );
    departmentIdByCode.set(code, result.insertId);
  }

  return departmentIdByCode;
}

async function migrateUsers(connection, departmentIdByCode) {
  const [legacyDepts] = await connection.query(
    'SELECT dID, tID, dName, dSName, dPassword, dEmail, dBC_BUM_HOD FROM tbldepts',
  );
  const lankaDepts = legacyDepts.filter(isLankaLegacyAccount);

  const userIdByLegacyDeptId = new Map();
  const userIdByUsername = new Map();
  const usedEmails = new Set();
  const passwordCache = new Map();

  async function hashPassword(rawPassword) {
    const password = String(rawPassword ?? 'admin123');
    if (!passwordCache.has(password)) {
      passwordCache.set(password, await bcrypt.hash(password, 10));
    }
    return passwordCache.get(password);
  }

  for (const row of lankaDepts) {
    const username = String(row.dName ?? `legacy-${row.dID}`)
      .trim()
      .toLowerCase()
      .replace(/\s+/g, '.');
    const role = roleFromLegacyName(row.dName, row.tID);
    const deptCode = deptCodeFromName(row.dName);
    const departmentId = departmentIdByCode.get(deptCode) ?? null;
    const emailRaw = String(row.dEmail ?? '').trim();
    let email = emailRaw.includes('@') ? emailRaw : `${username}@capexlanka.com`;
    if (usedEmails.has(email.toLowerCase())) {
      email = `${username}@capexlanka.com`;
    }
    usedEmails.add(email.toLowerCase());
    const password = await hashPassword(row.dPassword);

    const [existing] = await connection.query('SELECT id FROM users WHERE username = ?', [
      username,
    ]);
    if (existing.length > 0) {
      userIdByLegacyDeptId.set(Number(row.dID), existing[0].id);
      userIdByUsername.set(username, existing[0].id);
      continue;
    }

    const [result] = await connection.query(
      `INSERT INTO users
        (username, password, email, displayName, role, departmentId, reportsToUserId, isActive, createdAt, updatedAt)
       VALUES (?, ?, ?, ?, ?, ?, NULL, 1, NOW(), NOW())`,
      [
        username,
        password,
        email,
        String(row.dSName ?? row.dName ?? username).trim(),
        role,
        departmentId,
      ],
    );

    userIdByLegacyDeptId.set(Number(row.dID), result.insertId);
    userIdByUsername.set(username, result.insertId);
  }

  for (const row of lankaDepts) {
    const userId = userIdByLegacyDeptId.get(Number(row.dID));
    const managerLegacyId = Number(row.dBC_BUM_HOD);
    if (!userId || !managerLegacyId) continue;
    const managerId = userIdByLegacyDeptId.get(managerLegacyId);
    if (!managerId) continue;
    await connection.query('UPDATE users SET reportsToUserId = ? WHERE id = ?', [
      managerId,
      userId,
    ]);
  }

  return { userIdByLegacyDeptId, userIdByUsername };
}

async function migrateBudgets(connection, departmentIdByCode) {
  const budgetIdByLegacyKey = new Map();

  async function insertBudgetLine(source, row, financialYear, budgetType) {
    const deptCode = deptCodeFromName(row.bMDept || row.sbMDept || row.bDept || row.sbDept);
    const departmentId = departmentIdByCode.get(deptCode) ?? null;
    const legacyId = row.bID ?? row.sbID;
    const referenceCode =
      budgetType === 'strategic'
        ? `LEG-SB-${legacyId}`
        : `LEG-B${financialYear === '2025' ? '25' : ''}-${legacyId}`;
    const total = Number(row.bTotal ?? row.sbTotal ?? 0);
    const consumed = Number(row.bConsumed ?? row.sbConsumed ?? 0);
    const remaining = Number(row.bRemaining ?? row.sbRemaining ?? 0);
    const reserved = Math.max(total - consumed - remaining, 0);

    const [result] = await connection.query(
      `INSERT INTO budget_lines
        (referenceCode, description, budgetType, departmentCode, departmentId, financialYear, totalAmount, reservedAmount, utilizedAmount, isFrozen, createdAt, updatedAt)
       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0, NOW(), NOW())`,
      [
        referenceCode,
        String(row.bDesc ?? row.sbDesc ?? 'Legacy budget line').trim(),
        budgetType,
        deptCode,
        departmentId,
        financialYear,
        toDecimal(total),
        toDecimal(reserved),
        toDecimal(consumed),
      ],
    );

    budgetIdByLegacyKey.set(`${source}:${legacyId}`, result.insertId);
  }

  const [annual] = await connection.query('SELECT * FROM tblbudget');
  for (const row of annual.filter(isLankaBudgetRow)) {
    await insertBudgetLine('annual', row, '2024', 'annual');
  }

  const [annual2025] = await connection.query('SELECT * FROM tblbudget_2025');
  for (const row of annual2025.filter(isLankaBudgetRow)) {
    await insertBudgetLine('annual2025', row, '2025', 'annual');
  }

  const [strategic] = await connection.query('SELECT * FROM tblsbudget');
  for (const row of strategic.filter(isLankaBudgetRow)) {
    await insertBudgetLine('strategic', row, '2024', 'strategic');
  }

  return budgetIdByLegacyKey;
}

async function migrateCapex(connection, maps) {
  const {
    userIdByLegacyDeptId,
    budgetIdByLegacyKey,
    departmentIdByCode,
    legacyUsersById,
    userIdByRole,
    approvalsByCpId,
  } = maps;
  const [categories] = await connection.query('SELECT cID, cName FROM tblcategory');
  const categoryById = new Map(categories.map((row) => [Number(row.cID), row.cName]));
  const lankaLegacyDeptIds = [...userIdByLegacyDeptId.keys()];
  const [requests] = await connection.query('SELECT * FROM tblcp ORDER BY cpID');

  const capexIdByLegacyId = new Map();
  let skipped = 0;

  for (const cp of requests) {
    const legacyDeptId = Number(cp.cpDepartment);
    if (!lankaLegacyDeptIds.includes(legacyDeptId)) {
      skipped += 1;
      continue;
    }

    if (!cp.cpDetail && !cp.cpDAssetName && Number(cp.cpTot) === 0) {
      skipped += 1;
      continue;
    }

    const originatingDepartmentId =
      departmentIdByCode.get('LANKA') ?? [...departmentIdByCode.values()][0];
    const createdByUserId =
      userIdByLegacyDeptId.get(legacyDeptId) ??
      userIdByLegacyDeptId.get(1) ??
      [...userIdByLegacyDeptId.values()][0];

    const status = deriveCapexStatus(cp);
    const currentStage = status === 'pending' ? deriveCurrentStage(cp) : null;
    const currentApproverUserId = null;

    const [result] = await connection.query(
      `INSERT INTO capex_requests
        (referenceNo, costCenter, originatingDepartmentId, budgeted, expectedCompletionDate, replacementExpansion, category,
         detailOfProposal, desiredAssetNameSap, inHouseAvailability, enteredByEmail, extensionNumber,
         localCost, importedCost, currencyCode, foreignCurrencyAmount, exchangeRate,
         localCustomsDuty, importedCustomsDuty, localOtherCost, importedOtherCost, localGst, importedGst, totalAmount,
         paybackPeriod, internalRateOfReturn, glAccountNumber, internalOrderNumber, capexFormNumber,
         purchaseRequisitionNumber, purchaseOrderNumber, status, currentStage, currentApproverUserId, createdByUserId,
         createdAt, updatedAt)
       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())`,
      [
        `CEP-${cp.cpID}`,
        String(cp.cpCC ?? '0'),
        originatingDepartmentId,
        mapBudgeted(cp.cpDBudget),
        sanitizeDate(cp.cpEDate, sanitizeDate(cp.cpDate)),
        mapReplacement(cp.cpWERI),
        mapCategory(Number(cp.cpCid), categoryById.get(Number(cp.cpCid))),
        String(cp.cpDetail ?? '').trim() || 'Legacy capex request',
        String(cp.cpDAssetName ?? '').trim() || 'Legacy asset',
        mapYesNo(cp.cpOIHA),
        String(cp.cpEmail ?? 'legacy@capexlanka.com').trim(),
        String(cp.cpExtNo ?? '0'),
        toDecimal(cp.cpCostL),
        toDecimal(cp.cpCostI),
        sanitizeCurrency(cp.cpCur),
        toDecimal(cp.cpFCA),
        toDecimal(cp.cpFCR),
        toDecimal(cp.cpCDL),
        toDecimal(cp.cpCDI),
        toDecimal(cp.cpOthersL),
        toDecimal(cp.cpOthersI),
        toDecimal(cp.cpGSTL),
        toDecimal(cp.cpGSTI),
        toDecimal(cp.cpTot),
        cp.cpPBack || null,
        cp.cpIRR ? toDecimal(cp.cpIRR) : null,
        cp.cpINV_GLNo && cp.cpINV_GLNo !== '0' ? String(cp.cpINV_GLNo) : null,
        cp.cpINV_IO && cp.cpINV_IO !== '0' ? String(cp.cpINV_IO) : null,
        cp.cpINV_CPNO && cp.cpINV_CPNO !== '0' ? String(cp.cpINV_CPNO) : null,
        cp.cpERP_PR && cp.cpERP_PR !== '0' ? String(cp.cpERP_PR) : null,
        cp.cp_SP_PO && cp.cp_SP_PO !== '0' ? String(cp.cp_SP_PO) : null,
        status,
        currentStage,
        currentApproverUserId,
        createdByUserId,
        sanitizeDate(cp.cpDate) + ' 00:00:00',
      ],
    );

    capexIdByLegacyId.set(Number(cp.cpID), result.insertId);

    const budgetRef = Number(cp.cpBudgetRef);
    if (budgetRef > 0) {
      const budgetLineId =
        budgetIdByLegacyKey.get(`annual:${budgetRef}`) ??
        budgetIdByLegacyKey.get(`annual2025:${budgetRef}`);
      if (budgetLineId) {
        const usageStatus =
          status === 'approved' ? 'utilized' : status === 'rejected' ? 'released' : 'reserved';
        await connection.query(
          `INSERT INTO budget_line_usages
            (capexRequestId, budgetLineId, allocatedAmount, isPrimaryLine, usageStatus, createdAt, updatedAt)
           VALUES (?, ?, ?, 1, ?, NOW(), NOW())`,
          [result.insertId, budgetLineId, toDecimal(cp.cpTot), usageStatus],
        );
      }
    }

    const legacyApprovals = approvalsByCpId.get(Number(cp.cpID)) ?? [];
    const evidenceByRole = collectLegacyEvidence(
      cp,
      legacyApprovals,
      legacyUsersById,
      userIdByLegacyDeptId,
    );
    const planned = enrichPlanWithLegacyRoles(
      planLankaApprovalChain(userIdByRole),
      evidenceByRole,
      userIdByRole,
    );
    const resolvedSteps = resolveStepStatuses(planned, evidenceByRole, status);
    await insertApprovalChain(connection, result.insertId, resolvedSteps);
  }

  const [comments] = await connection.query('SELECT * FROM tblcpcomments ORDER BY cID');
  for (const comment of comments) {
    const capexRequestId = capexIdByLegacyId.get(Number(comment.cpID));
    if (!capexRequestId || !String(comment.cpComments ?? '').trim()) continue;
    const authorUserId =
      maps.userIdByLegacyDeptId.get(Number(comment.cpFDepartment)) ??
      maps.userIdByLegacyDeptId.get(1) ??
      [...maps.userIdByLegacyDeptId.values()][0];

    await connection.query(
      `INSERT INTO capex_comments (capexRequestId, authorUserId, message, createdAt)
       VALUES (?, ?, ?, ?)`,
      [
        capexRequestId,
        authorUserId,
        String(comment.cpComments).trim(),
        sanitizeDate(comment.cpCDateTime, sanitizeDate(comment.cpCDateTime, '2024-01-01')) +
          ' 00:00:00',
      ],
    );
  }

  await syncPendingStages(connection);

  return { imported: capexIdByLegacyId.size, skipped };
}

async function syncPendingStages(connection) {
  await connection.query(`
    UPDATE capex_requests cr
    INNER JOIN (
      SELECT s.capexRequestId, s.approverRole, s.assignedUserId
      FROM approval_steps s
      INNER JOIN (
        SELECT capexRequestId, MIN(sequenceNumber) AS minSequence
        FROM approval_steps
        WHERE stepStatus = 'pending'
        GROUP BY capexRequestId
      ) firstPending
        ON firstPending.capexRequestId = s.capexRequestId
       AND firstPending.minSequence = s.sequenceNumber
      WHERE s.stepStatus = 'pending'
    ) pending ON pending.capexRequestId = cr.id
    SET cr.currentStage = pending.approverRole,
        cr.currentApproverUserId = pending.assignedUserId
    WHERE cr.status = 'pending'
  `);
}

async function main() {
  const env = loadEnv();
  const sqlPath = process.argv[2]
    ? path.resolve(process.argv[2])
    : path.join(repoRoot, 'capex_lanka.sql');

  const connection = await createConnection({
    host: env.DB_HOST,
    port: Number(env.DB_PORT ?? 3306),
    user: env.DB_USERNAME,
    password: env.DB_PASSWORD,
    database: env.DB_DATABASE,
    multipleStatements: true,
  });

  try {
    console.log('Ensuring new app tables exist...');
    const [tables] = await connection.query("SHOW TABLES LIKE 'departments'");
    if (tables.length === 0) {
      throw new Error(
        'New app tables not found. Start the backend once (npm run start) so TypeORM creates the schema, then rerun import.',
      );
    }

    await ensureLegacyTables(connection, sqlPath);
    console.log('Clearing demo/new data...');
    await clearNewTables(connection);

    console.log('Migrating Lanka departments...');
    const departmentIdByCode = await migrateDepartments(connection);
    console.log(`  ${departmentIdByCode.size} departments (LANKA + CORP only)`);

    console.log('Migrating Lanka users (tbldepts only)...');
    const { userIdByLegacyDeptId, userIdByUsername } = await migrateUsers(
      connection,
      departmentIdByCode,
    );
    console.log(`  ${userIdByUsername.size} users`);

    console.log('Migrating Lanka budget lines (bMDept=Lanka)...');
    const budgetIdByLegacyKey = await migrateBudgets(connection, departmentIdByCode);
    console.log(`  ${budgetIdByLegacyKey.size} budget lines`);

    const [legacyDepts] = await connection.query('SELECT * FROM tbldepts');
    const legacyUsersById = new Map(
      legacyDepts.filter(isLankaLegacyAccount).map((row) => [Number(row.dID), row]),
    );

    const { userIdByRole } = await buildUserMaps(connection);

    const [legacyApprovals] = await connection.query('SELECT * FROM tblcpapprovals ORDER BY cpHID');
    const approvalsByCpId = new Map();
    for (const approval of legacyApprovals) {
      const cpId = Number(approval.cpID);
      if (!approvalsByCpId.has(cpId)) approvalsByCpId.set(cpId, []);
      approvalsByCpId.get(cpId).push(approval);
    }

    console.log('Migrating Lanka capex requests, approvals, and comments...');
    const { imported, skipped } = await migrateCapex(connection, {
      userIdByLegacyDeptId,
      budgetIdByLegacyKey,
      departmentIdByCode,
      legacyUsersById,
      userIdByRole,
      approvalsByCpId,
    });
    console.log(`  ${imported} capex requests imported (${skipped} empty rows skipped)`);

    console.log('\nLanka-only legacy import complete.');
    console.log('Set SITE_SCOPE=LANKA and SKIP_DEMO_SEED=true in .env, then restart the backend.');
    console.log('Login users: lanka-user, lanka, coa, inv, md (legacy passwords from tbldepts).');
  } finally {
    await connection.end();
  }
}

main().catch((error) => {
  console.error('Legacy import failed:', error.message);
  process.exit(1);
});
