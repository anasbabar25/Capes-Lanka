"use client";

import Sidebar from "@/components/dashboard/Sidebar";
import TopBar from "@/components/dashboard/TopBar";

type DashboardShellProps = {
  children: React.ReactNode;
};

export default function DashboardShell({ children }: DashboardShellProps) {
  return (
    <div className="min-h-screen bg-[#f4f9fc]">
      <Sidebar />
      <main className="min-h-screen pl-[280px]">
        <TopBar />
        <div className="p-4 lg:p-5">{children}</div>
      </main>
    </div>
  );
}
