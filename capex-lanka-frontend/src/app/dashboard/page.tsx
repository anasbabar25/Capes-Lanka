"use client";

import { useEffect, useState } from "react";
import CountCard from "@/components/dashboard/CountCard";
import { apiFetch } from "@/lib/api";
import type { CapexStats } from "@/types/capex";

export default function DashboardPage() {
  const [stats, setStats] = useState<CapexStats | null>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    apiFetch<CapexStats>("/capex/stats")
      .then(setStats)
      .finally(() => setLoading(false));
  }, []);

  return (
    <div className="space-y-8">
      <div className="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
        <CountCard
          title="Total Capex"
          value={loading ? "—" : stats?.total ?? 0}
          accent="cyan"
          icon={
            <svg aria-hidden viewBox="0 0 24 24" fill="none" className="h-5 w-5">
              <path d="M4 20V10l8-5 8 5v10" stroke="currentColor" strokeWidth="1.75" strokeLinejoin="round" />
            </svg>
          }
        />
        <CountCard
          title="Approved Capex"
          value={loading ? "—" : stats?.approved ?? 0}
          accent="green"
          icon={
            <svg aria-hidden viewBox="0 0 24 24" fill="none" className="h-5 w-5">
              <path d="M5 12l4 4 10-10" stroke="currentColor" strokeWidth="1.75" strokeLinecap="round" strokeLinejoin="round" />
            </svg>
          }
        />
        <CountCard
          title="Pending Capex"
          value={loading ? "—" : stats?.pending ?? 0}
          accent="amber"
          icon={
            <svg aria-hidden viewBox="0 0 24 24" fill="none" className="h-5 w-5">
              <path d="M12 8v4l3 2" stroke="currentColor" strokeWidth="1.75" strokeLinecap="round" />
              <circle cx="12" cy="12" r="8" stroke="currentColor" strokeWidth="1.75" />
            </svg>
          }
        />
        <CountCard
          title="Rejected Capex"
          value={loading ? "—" : stats?.rejected ?? 0}
          accent="rose"
          icon={
            <svg aria-hidden viewBox="0 0 24 24" fill="none" className="h-5 w-5">
              <path d="M8 8l8 8M16 8l-8 8" stroke="currentColor" strokeWidth="1.75" strokeLinecap="round" />
            </svg>
          }
        />
      </div>

      <section className="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 className="text-lg font-semibold text-slate-900">Quick insights</h2>
        <p className="mt-2 text-sm leading-relaxed text-slate-500">
          Track proposal volume and approval status. Originators submit a CEP,
          then it follows Head of Department → Business Controller → BUM →
          functional head → Financial Controller → CFO / MD → Inventory → ERP →
          Supply Chain.
        </p>
        {!loading && stats && (
          <p className="mt-4 text-sm text-slate-600">
            Current approval rate:{" "}
            <span className="font-semibold text-emerald-600">
              {stats.total > 0
                ? `${Math.round((stats.approved / stats.total) * 100)}%`
                : "0%"}
            </span>
          </p>
        )}
      </section>
    </div>
  );
}
