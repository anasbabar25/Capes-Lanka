export type BreadcrumbItem = {
  label: string;
  href?: string;
};

export type DashboardPageMeta = {
  title: string;
  breadcrumbs: BreadcrumbItem[];
};

export const dashboardPages: Record<string, DashboardPageMeta> = {
  "/dashboard": {
    title: "Dashboard",
    breadcrumbs: [{ label: "Dashboard" }],
  },
  "/dashboard/capex": {
    title: "Total Capex",
    breadcrumbs: [
      { label: "Dashboard", href: "/dashboard" },
      { label: "Capex" },
      { label: "Total Capex" },
    ],
  },
  "/dashboard/capex/new": {
    title: "New Capex",
    breadcrumbs: [
      { label: "Dashboard", href: "/dashboard" },
      { label: "Capex", href: "/dashboard/capex" },
      { label: "New Capex" },
    ],
  },
  "/dashboard/approvals": {
    title: "Pending Approvals",
    breadcrumbs: [
      { label: "Dashboard", href: "/dashboard" },
      { label: "Approvals" },
    ],
  },
  "/dashboard/budgets": {
    title: "Budget Master",
    breadcrumbs: [
      { label: "Dashboard", href: "/dashboard" },
      { label: "Budgets" },
    ],
  },
};

export function getDashboardPageMeta(pathname: string): DashboardPageMeta {
  if (dashboardPages[pathname]) {
    return dashboardPages[pathname];
  }

  const segments = pathname.split("/").filter(Boolean);
  const title =
    segments[segments.length - 1]
      ?.replace(/-/g, " ")
      .replace(/\b\w/g, (char) => char.toUpperCase()) ?? "Dashboard";

  const breadcrumbs: BreadcrumbItem[] = segments.map((segment, index) => {
    const href = `/${segments.slice(0, index + 1).join("/")}`;
    const label = segment
      .replace(/-/g, " ")
      .replace(/\b\w/g, (char) => char.toUpperCase());

    return index === segments.length - 1 ? { label } : { label, href };
  });

  return { title, breadcrumbs };
}
