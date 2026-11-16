"use client";

import { useEffect, useState } from "react";
import Link from "next/link";
import { apiFetch } from "@/lib/api";
import { formatMoney, formatRole } from "@/lib/roles";
import type { CapexRequest } from "@/types/capex";

export default function PendingApprovalsPage() {
  const [records, setRecords] = useState<CapexRequest[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    apiFetch<CapexRequest[]>("/capex/pending")
      .then(setRecords)
      .finally(() => setLoading(false));
  }, []);

  return (
    <div className="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
      <table className="min-w-full divide-y divide-slate-200">
        <thead className="bg-slate-50">
          <tr>
            {["Reference", "Asset", "Department", "Amount", "Stage", "Action"].map((heading) => (
              <th
                key={heading}
                className="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500"
              >
                {heading}
              </th>
            ))}
          </tr>
        </thead>
        <tbody className="divide-y divide-slate-100">
          {loading ? (
            <tr>
              <td colSpan={6} className="px-5 py-10 text-center text-sm text-slate-500">
                Loading pending approvals...
              </td>
            </tr>
          ) : records.length === 0 ? (
            <tr>
              <td colSpan={6} className="px-5 py-10 text-center text-sm text-slate-500">
                No requests waiting for you.
              </td>
            </tr>
          ) : (
            records.map((record) => (
              <tr key={record.id} className="hover:bg-slate-50/80">
                <td className="px-5 py-4 text-sm font-medium text-pll-cyan-dark">
                  {record.referenceNo}
                </td>
                <td className="px-5 py-4 text-sm">{record.desiredAssetNameSap}</td>
                <td className="px-5 py-4 text-sm text-slate-600">
                  {record.originatingDepartment.departmentName}
                </td>
                <td className="px-5 py-4 text-sm font-medium">
                  {formatMoney(record.totalAmount)}
                </td>
                <td className="px-5 py-4 text-sm text-slate-600">
                  {record.currentStage ? formatRole(record.currentStage) : "Completed"}
                </td>
                <td className="px-5 py-4">
                  <Link
                    href={`/dashboard/capex/${record.id}`}
                    className="text-sm font-semibold text-pll-cyan hover:underline"
                  >
                    Review
                  </Link>
                </td>
              </tr>
            ))
          )}
        </tbody>
      </table>
    </div>
  );
}
