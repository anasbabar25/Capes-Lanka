"use client";

import { FormEvent, useEffect, useState } from "react";
import { apiFetch } from "@/lib/api";
import { formatMoney } from "@/lib/roles";
import type { Budget, BudgetUploadResult } from "@/types/budget";

export default function BudgetsPage() {
  const [budgets, setBudgets] = useState<Budget[]>([]);
  const [file, setFile] = useState<File | null>(null);
  const [message, setMessage] = useState("");
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(true);
  const [uploading, setUploading] = useState(false);

  function loadBudgets() {
    return apiFetch<Budget[]>("/budgets").then(setBudgets);
  }

  useEffect(() => {
    loadBudgets().finally(() => setLoading(false));
  }, []);

  async function handleUpload(event: FormEvent) {
    event.preventDefault();
    if (!file) return;
    setError("");
    setMessage("");
    setUploading(true);
    try {
      const form = new FormData();
      form.append("file", file);
      const result = await apiFetch<BudgetUploadResult>("/budgets/upload", {
        method: "POST",
        body: form,
      });
      setMessage(`Imported ${result.importedCount} budget line(s).`);
      setFile(null);
      await loadBudgets();
    } catch (err) {
      setError(err instanceof Error ? err.message : "Upload failed");
    } finally {
      setUploading(false);
    }
  }

  return (
    <div className="space-y-6">
      <form
        onSubmit={handleUpload}
        className="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"
      >
        <h2 className="text-sm font-semibold text-slate-800">Upload budget CSV</h2>
        <p className="mt-1 text-sm text-slate-500">
          Headers: reference_code, description, department_code, budget_type, total_amount, financial_year
        </p>
        {error && (
          <p className="mt-3 rounded-lg border border-rose-200 bg-rose-50 px-3 py-2 text-sm text-rose-600">
            {error}
          </p>
        )}
        {message && (
          <p className="mt-3 rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm text-emerald-700">
            {message}
          </p>
        )}
        <div className="mt-4 flex flex-wrap items-center gap-3">
          <input
            type="file"
            accept=".csv"
            onChange={(event) => setFile(event.target.files?.[0] ?? null)}
            className="text-sm"
          />
          <button
            type="submit"
            disabled={!file || uploading}
            className="rounded-lg bg-pll-cyan px-4 py-2.5 text-sm font-semibold text-white disabled:opacity-70"
          >
            {uploading ? "Uploading..." : "Upload"}
          </button>
        </div>
      </form>

      <div className="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table className="min-w-full divide-y divide-slate-200">
          <thead className="bg-slate-50">
            <tr>
              {[
                "Reference",
                "Description",
                "Dept",
                "Type",
                "Total",
                "Reserved",
                "Utilized",
                "Remaining",
              ].map((heading) => (
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
                <td colSpan={8} className="px-5 py-10 text-center text-sm text-slate-500">
                  Loading budgets...
                </td>
              </tr>
            ) : (
              budgets.map((budget) => (
                <tr key={budget.id}>
                  <td className="px-5 py-4 text-sm font-medium text-pll-cyan-dark">
                    {budget.referenceCode}
                  </td>
                  <td className="px-5 py-4 text-sm">{budget.description}</td>
                  <td className="px-5 py-4 text-sm">{budget.departmentCode}</td>
                  <td className="px-5 py-4 text-sm capitalize">{budget.budgetType}</td>
                  <td className="px-5 py-4 text-sm">{formatMoney(budget.totalAmount)}</td>
                  <td className="px-5 py-4 text-sm">{formatMoney(budget.reservedAmount)}</td>
                  <td className="px-5 py-4 text-sm">{formatMoney(budget.utilizedAmount)}</td>
                  <td className="px-5 py-4 text-sm font-semibold">
                    {formatMoney(budget.remainingAmount)}
                  </td>
                </tr>
              ))
            )}
          </tbody>
        </table>
      </div>
    </div>
  );
}
