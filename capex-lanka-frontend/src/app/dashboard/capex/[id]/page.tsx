"use client";

import { FormEvent, useEffect, useState } from "react";
import Link from "next/link";
import { useParams, useRouter } from "next/navigation";
import CapexDetailView from "@/components/capex/CapexDetailView";
import { filterLankaApprovalSteps } from "@/lib/lanka-approval";
import FormInput, { fieldClass } from "@/components/ui/FormInput";
import { apiFetch } from "@/lib/api";
import { getStoredUser } from "@/lib/auth";
import type { CapexRequest } from "@/types/capex";

export default function CapexDetailPage() {
  const params = useParams<{ id: string }>();
  const router = useRouter();
  const user = getStoredUser();
  const [record, setRecord] = useState<CapexRequest | null>(null);
  const [comments, setComments] = useState("");
  const [paybackPeriod, setPaybackPeriod] = useState("");
  const [internalRateOfReturn, setInternalRateOfReturn] = useState("");
  const [glAccountNumber, setGlAccountNumber] = useState("");
  const [internalOrderNumber, setInternalOrderNumber] = useState("");
  const [capexFormNumber, setCapexFormNumber] = useState("");
  const [purchaseRequisitionNumber, setPurchaseRequisitionNumber] = useState("");
  const [purchaseOrderNumber, setPurchaseOrderNumber] = useState("");
  const [error, setError] = useState("");
  const [isLoading, setIsLoading] = useState(false);

  const activePendingStep = filterLankaApprovalSteps(record?.approvalSteps ?? []).find(
    (step) =>
      step.stepStatus === "pending" &&
      user &&
      (step.approverRole === user.role ||
        step.assignedUser?.role === user.role ||
        step.assignedUser?.id === user.id),
  );

  const isCurrentApprover = record?.status === "pending" && Boolean(activePendingStep);
  const activePendingRole = activePendingStep?.approverRole;

  useEffect(() => {
    apiFetch<CapexRequest>(`/capex/${params.id}`)
      .then(setRecord)
      .catch(() => setRecord(null));
  }, [params.id]);

  async function decide(decision: "approve" | "reject" | "return") {
    if (!record) return;
    setError("");
    setIsLoading(true);
    try {
      const updated = await apiFetch<CapexRequest>(`/capex/${record.id}/decide`, {
        method: "POST",
        body: JSON.stringify({
          decision,
          comments,
          paybackPeriod: paybackPeriod || undefined,
          internalRateOfReturn: internalRateOfReturn
            ? Number(internalRateOfReturn)
            : undefined,
          glAccountNumber: glAccountNumber || undefined,
          internalOrderNumber: internalOrderNumber || undefined,
          capexFormNumber: capexFormNumber || undefined,
          purchaseRequisitionNumber: purchaseRequisitionNumber || undefined,
          purchaseOrderNumber: purchaseOrderNumber || undefined,
        }),
      });
      setRecord(updated);
      setComments("");
      router.refresh();
    } catch (err) {
      setError(err instanceof Error ? err.message : "Decision failed");
    } finally {
      setIsLoading(false);
    }
  }

  async function handleApprove(event: FormEvent) {
    event.preventDefault();
    await decide("approve");
  }

  if (!record) {
    return <p className="text-sm text-slate-500">Loading request...</p>;
  }

  return (
    <div className="space-y-3">
      <div className="flex items-center justify-between gap-3">
        <Link
          href="/dashboard/capex"
          className="inline-flex items-center gap-2 text-sm font-medium text-slate-600 transition hover:text-pll-cyan-dark"
        >
          <span aria-hidden>←</span>
          Back to Total Capex
        </Link>
      </div>

      <CapexDetailView record={record} />

      {isCurrentApprover && (
        <form
          onSubmit={handleApprove}
          className="rounded-xl border border-amber-200 bg-amber-50/40 p-4 shadow-sm"
        >
          <h3 className="text-sm font-semibold text-slate-800">Your decision</h3>
          {error && (
            <p className="mt-2 rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs text-rose-600">
              {error}
            </p>
          )}
          {activePendingRole === "financial-controller" && (
            <div className="mt-3 grid gap-3 sm:grid-cols-2">
              <FormInput id="paybackPeriod" label="Payback" value={paybackPeriod} onChange={setPaybackPeriod} />
              <FormInput id="irr" label="IRR %" value={internalRateOfReturn} onChange={setInternalRateOfReturn} />
            </div>
          )}
          {activePendingRole === "inventory" && (
            <div className="mt-3 grid gap-3 sm:grid-cols-3">
              <FormInput id="gl" label="GL Account Number" value={glAccountNumber} onChange={setGlAccountNumber} required />
              <FormInput id="io" label="Internal Order Number" value={internalOrderNumber} onChange={setInternalOrderNumber} required />
              <FormInput id="cpno" label="Capex Form Number" value={capexFormNumber} onChange={setCapexFormNumber} />
            </div>
          )}
          {activePendingRole === "erp" && (
            <div className="mt-3">
              <FormInput id="pr" label="Purchase Requisition Number" value={purchaseRequisitionNumber} onChange={setPurchaseRequisitionNumber} required />
            </div>
          )}
          {activePendingRole === "supply-chain" && (
            <div className="mt-3">
              <FormInput id="po" label="Purchase Order Number" value={purchaseOrderNumber} onChange={setPurchaseOrderNumber} required />
            </div>
          )}
          <div className="mt-3">
            <label htmlFor="comments" className="block text-xs font-medium text-slate-500">
              Comments
            </label>
            <textarea
              id="comments"
              required
              minLength={3}
              rows={2}
              value={comments}
              onChange={(event) => setComments(event.target.value)}
              className={`${fieldClass} mt-1 resize-none`}
            />
          </div>
          <div className="mt-3 flex flex-wrap gap-2">
            <button
              type="submit"
              disabled={isLoading}
              className="rounded-lg bg-pll-cyan px-4 py-2.5 text-sm font-semibold text-white disabled:opacity-70"
            >
              Approve
            </button>
            <button
              type="button"
              disabled={isLoading}
              onClick={() => decide("reject")}
              className="rounded-lg bg-rose-600 px-4 py-2.5 text-sm font-semibold text-white disabled:opacity-70"
            >
              Reject
            </button>
            <button
              type="button"
              disabled={isLoading}
              onClick={() => decide("return")}
              className="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700"
            >
              Return
            </button>
          </div>
        </form>
      )}

    </div>
  );
}
