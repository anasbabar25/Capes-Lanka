"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import { getDashboardPageMeta } from "@/lib/dashboard-nav";

function ChevronRightIcon() {
  return (
    <svg
      aria-hidden
      viewBox="0 0 16 16"
      fill="none"
      className="h-3.5 w-3.5 shrink-0 text-slate-300"
    >
      <path
        d="M6 4l4 4-4 4"
        stroke="currentColor"
        strokeWidth="1.5"
        strokeLinecap="round"
        strokeLinejoin="round"
      />
    </svg>
  );
}

export default function TopBar() {
  const pathname = usePathname();
  const { title, breadcrumbs } = getDashboardPageMeta(pathname);

  return (
    <header className="sticky top-0 z-30 border-b border-slate-200/80 bg-white/90 backdrop-blur-md">
      <div className="px-6 py-4 lg:px-8">
        <div className="flex flex-wrap items-center gap-x-3 gap-y-2">
          <h1 className="text-xl font-semibold tracking-tight text-slate-900">
            {title}
          </h1>

          {breadcrumbs.length > 0 && (
            <>
              <span aria-hidden className="hidden h-4 w-px bg-slate-200 sm:block" />
              <nav
                aria-label="Breadcrumb"
                className="flex flex-wrap items-center gap-1.5 text-sm"
              >
                {breadcrumbs.map((crumb, index) => {
                  const isLast = index === breadcrumbs.length - 1;

                  return (
                    <span key={`${crumb.label}-${index}`} className="flex items-center gap-1.5">
                      {index > 0 && <ChevronRightIcon />}
                      {crumb.href && !isLast ? (
                        <Link
                          href={crumb.href}
                          className="font-medium text-slate-500 transition-colors hover:text-pll-cyan"
                        >
                          {crumb.label}
                        </Link>
                      ) : (
                        <span
                          className={
                            isLast
                              ? "font-medium text-pll-cyan"
                              : "font-medium text-slate-500"
                          }
                        >
                          {crumb.label}
                        </span>
                      )}
                    </span>
                  );
                })}
              </nav>
            </>
          )}
        </div>
      </div>
    </header>
  );
}
