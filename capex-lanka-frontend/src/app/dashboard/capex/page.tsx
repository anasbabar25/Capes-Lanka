"use client";

import { useCallback, useEffect, useState } from "react";
import Link from "next/link";
import StatusBadge from "@/components/dashboard/StatusBadge";
import TablePagination from "@/components/ui/TablePagination";
import { fieldClass } from "@/components/ui/FormInput";
import { apiFetch } from "@/lib/api";
import { filterLankaApprovalSteps } from "@/lib/lanka-approval";
import {
  CAPEX_STAGE_FILTER_OPTIONS,
  CAPEX_STATUS_FILTER_OPTIONS,
  formatDate,
  formatMoney,
  formatPendingStages,
} from "@/lib/roles";
import type { CapexRequest, PaginatedResponse } from "@/types/capex";

const DEFAULT_LIMIT = 20;

type CapexFilters = {
  search: string;
  status: string;
  currentStage: string;
};

function buildCapexQuery(page: number, limit: number, filters: CapexFilters) {
  const params = new URLSearchParams({
    page: String(page),
    limit: String(limit),
  });

  if (filters.search.trim()) {
    params.set("search", filters.search.trim());
  }
  if (filters.status) {
    params.set("status", filters.status);
  }
  if (filters.currentStage) {
    params.set("currentStage", filters.currentStage);
  }

  return params.toString();
}

export default function TotalCapexPage() {
  const [records, setRecords] = useState<CapexRequest[]>([]);
  const [loading, setLoading] = useState(true);
  const [page, setPage] = useState(1);
  const [limit, setLimit] = useState(DEFAULT_LIMIT);
  const [total, setTotal] = useState(0);
  const [totalPages, setTotalPages] = useState(1);
  const [search, setSearch] = useState("");
  const [debouncedSearch, setDebouncedSearch] = useState("");
  const [status, setStatus] = useState("");
  const [currentStage, setCurrentStage] = useState("");

  useEffect(() => {
    const timer = window.setTimeout(() => setDebouncedSearch(search), 300);
    return () => window.clearTimeout(timer);
  }, [search]);

  useEffect(() => {
    setPage(1);
  }, [debouncedSearch]);

  const loadRecords = useCallback(
    async (nextPage: number, nextLimit: number, filters: CapexFilters) => {
      setLoading(true);
      try {
        const response = await apiFetch<PaginatedResponse<CapexRequest>>(
          `/capex?${buildCapexQuery(nextPage, nextLimit, filters)}`,
        );
        setRecords(response.data);
        setTotal(response.total);
        setTotalPages(response.totalPages);
        setPage(response.page);
        setLimit(response.limit);
      } finally {
        setLoading(false);
      }
    },
    [],
  );

  useEffect(() => {
    loadRecords(page, limit, {
      search: debouncedSearch,
      status,
      currentStage,
    });
  }, [loadRecords, page, limit, debouncedSearch, status, currentStage]);

  function handlePageChange(nextPage: number) {
    setPage(nextPage);
  }

  function handleLimitChange(nextLimit: number) {
    setLimit(nextLimit);
    setPage(1);
  }

  function handleStatusChange(nextStatus: string) {
    setStatus(nextStatus);
    setPage(1);
  }

  function handleStageChange(nextStage: string) {
    setCurrentStage(nextStage);
    setPage(1);
  }

  function clearFilters() {
    setSearch("");
    setDebouncedSearch("");
    setStatus("");
    setCurrentStage("");
    setPage(1);
  }

  const hasActiveFilters = Boolean(search.trim() || status || currentStage);

  return (
    <div className="space-y-4">
      <div className="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div className="border-b border-slate-200 bg-slate-50/80 px-4 py-3 sm:px-5">
          <div className="flex flex-col gap-3 lg:flex-row lg:items-end">
            <div className="min-w-0 flex-1">
              <label htmlFor="capex-search" className="block text-xs font-medium text-slate-500">
                Search
              </label>
              <input
                id="capex-search"
                type="search"
                value={search}
                onChange={(event) => setSearch(event.target.value)}
                placeholder="Reference, asset, department, creator..."
                className={`${fieldClass} mt-1`}
              />
            </div>
            <div className="grid gap-3 sm:grid-cols-2 lg:w-[26rem]">
              <div>
                <label htmlFor="capex-status" className="block text-xs font-medium text-slate-500">
                  Status
                </label>
                <select
                  id="capex-status"
                  value={status}
                  onChange={(event) => handleStatusChange(event.target.value)}
                  className={`${fieldClass} mt-1`}
                >
                  {CAPEX_STATUS_FILTER_OPTIONS.map((option) => (
                    <option key={option.value || "all-statuses"} value={option.value}>
                      {option.label}
                    </option>
                  ))}
                </select>
              </div>
              <div>
                <label htmlFor="capex-stage" className="block text-xs font-medium text-slate-500">
                  Current stage
                </label>
                <select
                  id="capex-stage"
                  value={currentStage}
                  onChange={(event) => handleStageChange(event.target.value)}
                  className={`${fieldClass} mt-1`}
                >
                  {CAPEX_STAGE_FILTER_OPTIONS.map((option) => (
                    <option key={option.value || "all-stages"} value={option.value}>
                      {option.label}
                    </option>
                  ))}
                </select>
              </div>
            </div>
            {hasActiveFilters && (
              <button
                type="button"
                onClick={clearFilters}
                className="shrink-0 rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-xs font-semibold text-slate-600 transition hover:border-slate-300 hover:text-slate-800"
              >
                Clear filters
              </button>
            )}
          </div>
        </div>

        <div className="overflow-x-auto">
          <table className="min-w-full divide-y divide-slate-200">
            <thead className="bg-slate-50">
              <tr>
                {[
                  "Reference",
                  "Asset Name",
                  "Department",
                  "Amount",
                  "Status",
                  "Current Stage",
                  "Created By",
                  "Date",
                  "Details",
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
                  <td colSpan={9} className="px-5 py-10 text-center text-sm text-slate-500">
                    Loading capex records...
                  </td>
                </tr>
              ) : records.length === 0 ? (
                <tr>
                  <td colSpan={9} className="px-5 py-10 text-center text-sm text-slate-500">
                    {hasActiveFilters
                      ? "No capex records match your filters."
                      : "No capex records found."}
                  </td>
                </tr>
              ) : (
                records.map((record) => (
                  <tr key={record.id} className="hover:bg-slate-50/80">
                    <td className="whitespace-nowrap px-5 py-4 text-sm font-medium text-slate-800">
                      {record.referenceNo}
                    </td>
                    <td className="px-5 py-4 text-sm text-slate-900">
                      <div className="max-w-xs truncate font-medium">
                        {record.desiredAssetNameSap}
                      </div>
                    </td>
                    <td className="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
                      {record.originatingDepartment?.departmentName}
                    </td>
                    <td className="whitespace-nowrap px-5 py-4 text-sm font-medium text-slate-900">
                      {formatMoney(record.totalAmount)}
                    </td>
                    <td className="whitespace-nowrap px-5 py-4">
                      <StatusBadge status={record.status} />
                    </td>
                    <td className="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
                      {formatPendingStages(
                        filterLankaApprovalSteps(record.approvalSteps ?? []),
                        record.currentStage,
                      )}
                    </td>
                    <td className="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
                      {record.createdBy.displayName}
                    </td>
                    <td className="whitespace-nowrap px-5 py-4 text-sm text-slate-500">
                      {formatDate(record.createdAt)}
                    </td>
                    <td className="whitespace-nowrap px-5 py-4">
                      <Link
                        href={`/dashboard/capex/${record.id}`}
                        className="inline-flex items-center rounded-lg border border-pll-cyan/30 bg-pll-cyan/5 px-3 py-1.5 text-xs font-semibold text-pll-cyan-dark transition hover:border-pll-cyan hover:bg-pll-cyan/10"
                      >
                        Details
                      </Link>
                    </td>
                  </tr>
                ))
              )}
            </tbody>
          </table>
        </div>

        <TablePagination
          page={page}
          limit={limit}
          total={total}
          totalPages={totalPages}
          onPageChange={handlePageChange}
          onLimitChange={handleLimitChange}
        />
      </div>
    </div>
  );
}
