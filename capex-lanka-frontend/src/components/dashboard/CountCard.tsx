import type { ReactNode } from "react";

type CountCardProps = {
  title: string;
  value: number | string;
  icon: ReactNode;
  accent?: "cyan" | "green" | "amber" | "rose" | "slate";
};

const accentStyles = {
  cyan: {
    card: "border-pll-cyan/20 bg-gradient-to-br from-pll-cyan-light/80 to-white",
    icon: "bg-pll-cyan/15 text-pll-cyan",
    value: "text-pll-cyan-dark",
  },
  green: {
    card: "border-emerald-200 bg-gradient-to-br from-emerald-50 to-white",
    icon: "bg-emerald-100 text-emerald-600",
    value: "text-emerald-700",
  },
  amber: {
    card: "border-amber-200 bg-gradient-to-br from-amber-50 to-white",
    icon: "bg-amber-100 text-amber-600",
    value: "text-amber-700",
  },
  rose: {
    card: "border-rose-200 bg-gradient-to-br from-rose-50 to-white",
    icon: "bg-rose-100 text-rose-600",
    value: "text-rose-700",
  },
  slate: {
    card: "border-slate-200 bg-gradient-to-br from-slate-50 to-white",
    icon: "bg-slate-100 text-slate-600",
    value: "text-slate-800",
  },
};

export default function CountCard({
  title,
  value,
  icon,
  accent = "cyan",
}: CountCardProps) {
  const styles = accentStyles[accent];

  return (
    <article
      className={`rounded-2xl border p-5 shadow-sm transition-shadow hover:shadow-md ${styles.card}`}
    >
      <div className="flex items-start justify-between gap-4">
        <div>
          <p className="text-sm font-medium text-slate-500">{title}</p>
          <p className={`mt-2 text-3xl font-semibold tracking-tight ${styles.value}`}>
            {value}
          </p>
        </div>
        <div
          className={`flex h-11 w-11 shrink-0 items-center justify-center rounded-xl ${styles.icon}`}
        >
          {icon}
        </div>
      </div>
    </article>
  );
}
