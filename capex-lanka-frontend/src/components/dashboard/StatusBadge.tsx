import type { CapexStatus } from "@/types/capex";

const styles: Record<string, string> = {
  approved: "bg-emerald-100 text-emerald-700 ring-emerald-200",
  pending: "bg-amber-100 text-amber-700 ring-amber-200",
  rejected: "bg-rose-100 text-rose-700 ring-rose-200",
  returned: "bg-slate-100 text-slate-700 ring-slate-200",
  waiting: "bg-slate-100 text-slate-500 ring-slate-200",
  utilized: "bg-emerald-100 text-emerald-700 ring-emerald-200",
  reserved: "bg-sky-100 text-sky-700 ring-sky-200",
  released: "bg-slate-100 text-slate-500 ring-slate-200",
};

type StatusBadgeProps = {
  status: CapexStatus | string;
};

export default function StatusBadge({ status }: StatusBadgeProps) {
  const className = styles[status] ?? styles.pending;
  return (
    <span
      className={`inline-flex rounded-full px-2.5 py-1 text-xs font-semibold capitalize ring-1 ring-inset ${className}`}
    >
      {status.replace(/-/g, " ")}
    </span>
  );
}
