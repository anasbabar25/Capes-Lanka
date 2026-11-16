import type { ReactNode } from "react";
import StatusBadge from "@/components/dashboard/StatusBadge";
import {
  filterLankaApprovalSteps,
  sortByLankaApprovalOrder,
} from "@/lib/lanka-approval";
import {
  formatDate,
  formatMoney,
  formatPendingStages,
  formatRole,
  ROLE_LABELS,
} from "@/lib/roles";
import type { ApprovalStep, CapexRequest } from "@/types/capex";
import type { UserRole } from "@/types/auth";

function stepDotClass(status: ApprovalStep["stepStatus"]) {
  switch (status) {
    case "approved":
      return "bg-emerald-500";
    case "rejected":
      return "bg-rose-500";
    case "pending":
      return "bg-amber-400 ring-4 ring-amber-100";
    default:
      return "bg-slate-300";
  }
}

function stepStatusLabel(status: ApprovalStep["stepStatus"]) {
  switch (status) {
    case "approved":
      return "Approved";
    case "rejected":
      return "Rejected";
    case "pending":
      return "Pending";
    case "skipped":
      return "Skipped";
    default:
      return "Waiting";
  }
}

function stepStatusTextClass(status: ApprovalStep["stepStatus"]) {
  switch (status) {
    case "approved":
      return "text-emerald-600";
    case "rejected":
      return "text-rose-600";
    case "pending":
      return "text-amber-600";
    default:
      return "text-slate-400";
  }
}

function stepActorLabel(step: ApprovalStep) {
  if (step.stepStatus !== "approved" && step.stepStatus !== "rejected") {
    return null;
  }

  const actorRole = step.decidedBy?.role ?? step.assignedUser?.role ?? step.approverRole;
  return formatRole(actorRole);
}

function connectorClass(
  left: ApprovalStep["stepStatus"],
  right: ApprovalStep["stepStatus"],
) {
  if (left === "approved" && (right === "approved" || right === "pending")) {
    return "bg-emerald-400";
  }
  if (left === "rejected" || right === "rejected") {
    return "bg-rose-200";
  }
  return "bg-slate-200";
}

export function CapexApprovalFlow({ steps }: { steps: ApprovalStep[] }) {
  const lankaSteps = sortByLankaApprovalOrder(filterLankaApprovalSteps(steps));
  if (lankaSteps.length === 0) return null;

  const orderedSteps = lankaSteps;

  return (
    <div className="overflow-x-auto pb-1">
      <ol className="flex min-w-max items-start gap-0 px-1">
        {orderedSteps.map((step, index) => {
          const isLast = index === orderedSteps.length - 1;
          const nextStep = orderedSteps[index + 1];
          const actorLabel = stepActorLabel(step);

          return (
            <li key={step.id} className="flex items-start">
              <div className="flex w-[7.5rem] shrink-0 flex-col items-center text-center sm:w-28">
                <span
                  className={`h-3.5 w-3.5 shrink-0 rounded-full ${stepDotClass(step.stepStatus)}`}
                />
                <p className="mt-2 text-[11px] font-semibold leading-tight text-slate-900">
                  {ROLE_LABELS[step.approverRole as UserRole] ?? step.approverRole}
                </p>
                <p
                  className={`mt-0.5 text-[10px] font-medium ${stepStatusTextClass(step.stepStatus)}`}
                >
                  {stepStatusLabel(step.stepStatus)}
                </p>
                {actorLabel && (
                  <p className="mt-1 line-clamp-2 text-[10px] leading-snug text-slate-500">
                    by {actorLabel}
                  </p>
                )}
              </div>
              {!isLast && nextStep && (
                <div
                  className={`mx-1 mt-[7px] h-0.5 w-8 shrink-0 sm:mx-2 sm:w-12 ${connectorClass(step.stepStatus, nextStep.stepStatus)}`}
                  aria-hidden
                />
              )}
            </li>
          );
        })}
      </ol>
    </div>
  );
}

function labelize(value: string) {
  return value.replace(/-/g, " ").replace(/\b\w/g, (char) => char.toUpperCase());
}

function display(value: ReactNode) {
  if (value === null || value === undefined || value === "") return "—";
  return value;
}

function InfoItem({ label, value }: { label: string; value: ReactNode }) {
  return (
    <div className="min-w-0">
      <p className="text-[10px] font-medium uppercase tracking-wide text-slate-400">{label}</p>
      <p className="mt-0.5 text-xs leading-snug text-slate-900">{display(value)}</p>
    </div>
  );
}

function InfoGrid({ children, cols = 4 }: { children: ReactNode; cols?: 3 | 4 }) {
  return (
    <div
      className={`grid gap-x-4 gap-y-2.5 sm:grid-cols-2 ${cols === 4 ? "lg:grid-cols-4" : "lg:grid-cols-3"}`}
    >
      {children}
    </div>
  );
}

function SectionDivider({ label }: { label: string }) {
  return (
    <div className="flex items-center gap-2">
      <p className="shrink-0 text-[10px] font-semibold uppercase tracking-wide text-slate-400">
        {label}
      </p>
      <div className="h-px flex-1 bg-slate-100" />
    </div>
  );
}

function CostRow({
  label,
  local,
  imported,
}: {
  label: string;
  local: string;
  imported: string;
}) {
  return (
    <div className="grid grid-cols-[1fr_auto_auto] items-center gap-3 py-1.5 text-xs">
      <span className="text-slate-600">{label}</span>
      <span className="tabular-nums text-slate-900">{formatMoney(local)}</span>
      <span className="tabular-nums text-slate-900">{formatMoney(imported)}</span>
    </div>
  );
}

export default function CapexDetailView({ record }: { record: CapexRequest }) {
  const primaryBudget = record.budgetUsages?.find((usage) => usage.isPrimaryLine);
  const additionalBudgets =
    record.budgetUsages?.filter((usage) => !usage.isPrimaryLine) ?? [];

  const pendingAt = formatPendingStages(record.approvalSteps, record.currentStage);
  const currentStageRole = formatPendingStages(record.approvalSteps, record.currentStage);

  return (
    <section className="rounded-xl bg-white p-4 shadow-sm ring-1 ring-slate-200/70">
      <div className="flex flex-wrap items-start justify-between gap-3 border-b border-slate-100 pb-3">
        <div className="min-w-0 flex-1">
          <div className="flex flex-wrap items-center gap-1.5">
            <StatusBadge status={record.status} />
            <span className="rounded-full bg-slate-100 px-2 py-0.5 text-[11px] font-medium text-slate-600">
              {pendingAt}
            </span>
          </div>
          <h1 className="mt-1.5 text-lg font-semibold tracking-tight text-slate-900 sm:text-xl">
            {record.desiredAssetNameSap}
          </h1>
          <p className="mt-0.5 text-xs text-slate-500">
            {record.referenceNo} · {record.originatingDepartment.departmentName}
          </p>
        </div>
        <div className="text-right">
          <p className="text-[10px] font-medium uppercase tracking-wide text-slate-400">Total cost</p>
          <p className="text-lg font-semibold tabular-nums text-slate-900">
            {formatMoney(record.totalAmount)}
          </p>
        </div>
      </div>

      <div className="mt-3">
        <InfoGrid>
          <InfoItem label="Submitted by" value={record.createdBy.displayName} />
          <InfoItem label="Submitted on" value={formatDate(record.createdAt)} />
          <InfoItem label="Expected completion" value={formatDate(record.expectedCompletionDate)} />
          <InfoItem label="Current stage" value={currentStageRole} />
        </InfoGrid>
      </div>

      <div className="mt-4 grid gap-4 lg:grid-cols-2">
        <div className="space-y-3">
          <SectionDivider label="Overview" />
          <InfoGrid>
            <InfoItem label="Cost center" value={record.costCenter} />
            <InfoItem label="Department" value={record.originatingDepartment.departmentName} />
            <InfoItem label="Budgeted" value={labelize(record.budgeted)} />
            <InfoItem label="Category" value={labelize(record.category)} />
            <InfoItem label="Replacement / expansion" value={labelize(record.replacementExpansion)} />
            <InfoItem label="In-house asset" value={labelize(record.inHouseAvailability)} />
            <InfoItem label="Contact email" value={record.enteredByEmail} />
            <InfoItem label="Extension" value={record.extensionNumber} />
          </InfoGrid>

          <SectionDivider label="Proposal" />
          <p className="text-xs leading-relaxed text-slate-700">{record.detailOfProposal}</p>

          <SectionDivider label="Budget" />
          <div className="space-y-1.5">
            {primaryBudget ? (
              <div className="flex items-baseline justify-between gap-2 rounded-lg bg-slate-50 px-2.5 py-1.5">
                <div className="min-w-0">
                  <p className="truncate text-xs font-medium text-slate-900">
                    {primaryBudget.budgetLine.description}
                  </p>
                  <p className="text-[10px] text-slate-500">
                    {primaryBudget.budgetLine.referenceCode} · Primary
                  </p>
                </div>
                <p className="shrink-0 text-xs font-semibold tabular-nums text-slate-900">
                  {formatMoney(primaryBudget.allocatedAmount)}
                </p>
              </div>
            ) : (
              <p className="text-xs text-slate-600">Unbudgeted request</p>
            )}
            {additionalBudgets.map((usage) => (
              <div
                key={usage.id}
                className="flex items-baseline justify-between gap-2 px-2.5 py-1"
              >
                <div className="min-w-0">
                  <p className="truncate text-xs text-slate-800">{usage.budgetLine.description}</p>
                  <p className="text-[10px] text-slate-400">
                    {usage.budgetLine.referenceCode} · Virement
                  </p>
                </div>
                <p className="shrink-0 text-xs tabular-nums text-slate-700">
                  {formatMoney(usage.allocatedAmount)}
                </p>
              </div>
            ))}
          </div>
        </div>

        <div className="space-y-3">
          <SectionDivider label="Cost breakdown" />
          <div>
            <div className="grid grid-cols-[1fr_auto_auto] gap-3 border-b border-slate-100 pb-1 text-[10px] font-medium uppercase tracking-wide text-slate-400">
              <span>Item</span>
              <span>Local</span>
              <span>Import</span>
            </div>
            <div className="divide-y divide-slate-50">
              <CostRow label="Equipment" local={record.localCost} imported={record.importedCost} />
              <CostRow
                label="Customs duty"
                local={record.localCustomsDuty}
                imported={record.importedCustomsDuty}
              />
              <CostRow
                label="Other costs"
                local={record.localOtherCost}
                imported={record.importedOtherCost}
              />
              <CostRow label="GST" local={record.localGst} imported={record.importedGst} />
            </div>
            <div className="mt-2 flex items-center justify-between gap-2 rounded-lg bg-pll-cyan/5 px-2.5 py-1.5">
              <span className="text-xs font-medium text-slate-700">Total project cost</span>
              <span className="text-sm font-semibold tabular-nums text-pll-cyan-dark">
                {formatMoney(record.totalAmount)}
              </span>
            </div>
            {(record.currencyCode ||
              Number(record.foreignCurrencyAmount) > 0 ||
              Number(record.exchangeRate) > 0) && (
              <div className="mt-2 grid grid-cols-3 gap-2">
                <InfoItem label="Currency" value={record.currencyCode ?? "LKR"} />
                <InfoItem label="Foreign amount" value={formatMoney(record.foreignCurrencyAmount)} />
                <InfoItem label="Exchange rate" value={record.exchangeRate} />
              </div>
            )}
          </div>

          <SectionDivider label="Financial & execution" />
          <InfoGrid cols={3}>
            <InfoItem label="Payback period" value={record.paybackPeriod ?? "N/A"} />
            <InfoItem
              label="IRR"
              value={record.internalRateOfReturn ? `${record.internalRateOfReturn}%` : "N/A"}
            />
            <InfoItem label="GL account" value={record.glAccountNumber} />
            <InfoItem label="Internal order" value={record.internalOrderNumber} />
            <InfoItem label="Capex form no." value={record.capexFormNumber} />
            <InfoItem label="PR number" value={record.purchaseRequisitionNumber} />
            <InfoItem label="PO number" value={record.purchaseOrderNumber} />
          </InfoGrid>
        </div>
      </div>

      {record.approvalSteps && record.approvalSteps.length > 0 && (
        <div className="mt-4 border-t border-slate-100 pt-3">
          <SectionDivider label="Approval flow" />
          <div className="mt-3">
            <CapexApprovalFlow steps={record.approvalSteps} />
          </div>
        </div>
      )}

      {record.comments && record.comments.length > 0 && (
        <div className="mt-4 border-t border-slate-100 pt-3">
          <SectionDivider label="Comments" />
          <ul className="mt-2 space-y-2">
            {record.comments.map((comment) => (
              <li key={comment.id} className="text-xs">
                <p className="leading-relaxed text-slate-700">{comment.message}</p>
                <p className="mt-0.5 text-[10px] text-slate-400">
                  {comment.author.displayName} · {formatDate(comment.createdAt)}
                </p>
              </li>
            ))}
          </ul>
        </div>
      )}
    </section>
  );
}
