"use client";

import Image from "next/image";
import Link from "next/link";
import { usePathname, useRouter } from "next/navigation";
import { useEffect, useState, type ReactNode } from "react";
import { clearAuth, getStoredUser } from "@/lib/auth";
import { canApproveCapex, canCreateCapex, canManageBudgets } from "@/lib/roles";
import type { AuthUser } from "@/types/auth";

type NavItem = {
  label: string;
  href?: string;
  icon: ReactNode;
  children?: { label: string; href: string }[];
};

function DashboardIcon() {
  return (
    <svg aria-hidden viewBox="0 0 24 24" fill="none" className="h-[18px] w-[18px]">
      <path d="M4 13h7V4H4v9Zm9 7h7v-9h-7v9ZM4 20h7v-5H4v5Zm9-16v5h7V4h-7Z" stroke="currentColor" strokeWidth="1.75" strokeLinejoin="round" />
    </svg>
  );
}

function CapexIcon() {
  return (
    <svg aria-hidden viewBox="0 0 24 24" fill="none" className="h-[18px] w-[18px]">
      <path d="M7 4h10v16H7V4Z" stroke="currentColor" strokeWidth="1.75" />
      <path d="M9 8h6M9 12h6M9 16h4" stroke="currentColor" strokeWidth="1.75" strokeLinecap="round" />
    </svg>
  );
}

function LogoutIcon() {
  return (
    <svg aria-hidden viewBox="0 0 24 24" fill="none" className="h-[18px] w-[18px]">
      <path d="M10 7V5a2 2 0 0 1 2-2h5v18h-5a2 2 0 0 1-2-2v-2" stroke="currentColor" strokeWidth="1.75" strokeLinecap="round" />
      <path d="M14 12H4m0 0 3-3m-3 3 3 3" stroke="currentColor" strokeWidth="1.75" strokeLinecap="round" strokeLinejoin="round" />
    </svg>
  );
}

function BudgetIcon() {
  return (
    <svg aria-hidden viewBox="0 0 24 24" fill="none" className="h-[18px] w-[18px]">
      <path d="M4 19V7h16v12H4Z" stroke="currentColor" strokeWidth="1.75" />
      <path d="M8 7V5h8v2M8 12h8M8 16h5" stroke="currentColor" strokeWidth="1.75" strokeLinecap="round" />
    </svg>
  );
}

function ApprovalIcon() {
  return (
    <svg aria-hidden viewBox="0 0 24 24" fill="none" className="h-[18px] w-[18px]">
      <path d="M5 12l4 4 10-10" stroke="currentColor" strokeWidth="1.75" strokeLinecap="round" strokeLinejoin="round" />
    </svg>
  );
}

function buildNavItems(user: AuthUser | null): NavItem[] {
  const capexChildren = [
    ...(user && canCreateCapex(user.role)
      ? [{ label: "New Capex", href: "/dashboard/capex/new" }]
      : []),
    { label: "Total Capex", href: "/dashboard/capex" },
  ];

  const items: NavItem[] = [
    {
      label: "Dashboard",
      href: "/dashboard",
      icon: <DashboardIcon />,
    },
    {
      label: "Capex",
      icon: <CapexIcon />,
      children: capexChildren,
    },
  ];

  if (user && canApproveCapex(user.role)) {
    items.push({
      label: "Pending Approvals",
      href: "/dashboard/approvals",
      icon: <ApprovalIcon />,
    });
  }

  if (user && canManageBudgets(user.role)) {
    items.push({
      label: "Budgets",
      href: "/dashboard/budgets",
      icon: <BudgetIcon />,
    });
  }

  return items;
}

function NavIconBox({
  active,
  children,
}: {
  active: boolean;
  children: ReactNode;
}) {
  return (
    <span
      className={`flex h-9 w-9 shrink-0 items-center justify-center rounded-lg transition-all duration-200 ${
        active
          ? "bg-white/20 text-white shadow-inner"
          : "bg-white/[0.06] text-slate-400 group-hover:bg-pll-cyan/15 group-hover:text-pll-cyan"
      }`}
    >
      {children}
    </span>
  );
}

export default function Sidebar() {
  const pathname = usePathname();
  const router = useRouter();
  const [user, setUser] = useState<AuthUser | null>(null);
  const [capexOpen, setCapexOpen] = useState(
    pathname.startsWith("/dashboard/capex"),
  );

  useEffect(() => {
    setUser(getStoredUser());
    setCapexOpen(pathname.startsWith("/dashboard/capex"));
  }, [pathname]);

  function handleLogout() {
    clearAuth();
    router.push("/login");
  }

  function isActive(href: string) {
    return pathname === href;
  }

  return (
    <aside className="sidebar-bg fixed inset-y-0 left-0 z-40 flex h-screen w-[280px] flex-col overflow-hidden rounded-r-2xl border-r border-pll-cyan/10 text-white shadow-[4px_0_32px_-8px_rgba(0,0,0,0.35)]">
      {/* Decorative triangle accent */}
      <div
        aria-hidden
        className="login-triangle pointer-events-none absolute -right-6 top-20 h-24 w-24 bg-pll-cyan/[0.07]"
      />

      {/* Brand header */}
      <div className="relative border-b border-white/[0.08] px-5 py-6">
        <div className="flex items-center gap-3.5">
          <div className="relative h-12 w-12 overflow-hidden rounded-xl shadow-[0_4px_20px_-4px_rgba(0,173,239,0.5)] ring-1 ring-pll-cyan/40">
            <Image
              src="/PLL-logo.jpeg"
              alt="Capex Lanka"
              fill
              className="object-cover"
            />
          </div>
          <div className="min-w-0">
            <p className="truncate text-[15px] font-semibold tracking-tight text-white">
              Capex Lanka
            </p>
            <p className="truncate text-[11px] font-medium leading-tight text-pll-cyan/90">
              Capital Expenditure Proposal
            </p>
          </div>
        </div>
      </div>

      {/* Navigation label */}
      <div className="px-5 pt-5 pb-2">
        <p className="text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-500">
          Main Menu
        </p>
      </div>

      <nav className="flex-1 space-y-1 overflow-y-auto px-3 pb-4">
        {buildNavItems(user).map((item) => {
          if (item.children) {
            const childActive = item.children.some((child) =>
              pathname.startsWith(child.href),
            );

            return (
              <div key={item.label}>
                <button
                  type="button"
                  onClick={() => setCapexOpen((open) => !open)}
                  className={`group flex w-full cursor-pointer items-center justify-between rounded-xl px-2.5 py-2 text-sm font-medium transition-all duration-200 ${
                    childActive
                      ? "bg-pll-cyan/10 text-pll-cyan shadow-[inset_3px_0_0_0_#00adef]"
                      : "text-slate-300 hover:bg-white/[0.04] hover:text-white"
                  }`}
                >
                  <span className="flex items-center gap-3">
                    <NavIconBox active={childActive}>{item.icon}</NavIconBox>
                    {item.label}
                  </span>
                  <svg
                    aria-hidden
                    viewBox="0 0 20 20"
                    fill="none"
                    className={`h-4 w-4 shrink-0 text-slate-500 transition-transform duration-200 ${capexOpen ? "rotate-180 text-pll-cyan" : ""}`}
                  >
                    <path d="M5 7.5 10 12.5 15 7.5" stroke="currentColor" strokeWidth="1.75" strokeLinecap="round" strokeLinejoin="round" />
                  </svg>
                </button>

                {capexOpen && (
                  <div className="relative mt-1 ml-5 space-y-0.5 border-l border-pll-cyan/20 pl-3">
                    {item.children.map((child) => {
                      const active = isActive(child.href);
                      return (
                        <Link
                          key={child.href}
                          href={child.href}
                          className={`group/sub flex items-center gap-2.5 rounded-lg px-3 py-2 text-[13px] font-medium transition-all duration-200 ${
                            active
                              ? "bg-gradient-to-r from-pll-cyan to-pll-cyan-dark text-white shadow-[0_4px_16px_-4px_rgba(0,173,239,0.55)]"
                              : "text-slate-400 hover:bg-white/[0.04] hover:text-white"
                          }`}
                        >
                          <span
                            className={`h-1.5 w-1.5 shrink-0 rounded-full transition-colors ${
                              active
                                ? "bg-white"
                                : "bg-slate-600 group-hover/sub:bg-pll-cyan/60"
                            }`}
                          />
                          {child.label}
                        </Link>
                      );
                    })}
                  </div>
                )}
              </div>
            );
          }

          const active = isActive(item.href!);

          return (
            <Link
              key={item.href}
              href={item.href!}
              className={`group flex items-center gap-3 rounded-xl px-2.5 py-2 text-sm font-medium transition-all duration-200 ${
                active
                  ? "bg-gradient-to-r from-pll-cyan to-pll-cyan-dark text-white shadow-[0_4px_20px_-6px_rgba(0,173,239,0.65)]"
                  : "text-slate-300 hover:bg-white/[0.04] hover:text-white"
              }`}
            >
              <NavIconBox active={active}>{item.icon}</NavIconBox>
              {item.label}
            </Link>
          );
        })}
      </nav>

      {/* User footer */}
      <div className="relative border-t border-white/[0.08] p-4">
        {user && (
          <div className="mb-3 flex items-center gap-3 rounded-xl border border-white/[0.06] bg-white/[0.04] px-3 py-3 backdrop-blur-sm">
            <div className="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-pll-cyan to-pll-cyan-dark text-xs font-bold text-white">
              {user.displayName.charAt(0)}
            </div>
            <div className="min-w-0">
              <p className="truncate text-sm font-medium text-white">
                {user.displayName}
              </p>
              <p className="truncate text-[11px] text-pll-cyan/80">
                {user.roleLabel}
              </p>
            </div>
          </div>
        )}
        <button
          type="button"
          onClick={handleLogout}
          className="group flex w-full cursor-pointer items-center gap-3 rounded-xl px-2.5 py-2 text-sm font-medium text-slate-400 transition-all duration-200 hover:bg-rose-500/10 hover:text-rose-300"
        >
          <span className="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white/[0.06] transition-colors group-hover:bg-rose-500/15 group-hover:text-rose-300">
            <LogoutIcon />
          </span>
          Sign out
        </button>
      </div>
    </aside>
  );
}
