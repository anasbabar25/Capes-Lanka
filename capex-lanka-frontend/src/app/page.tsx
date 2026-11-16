import Link from "next/link";
import AppBrand from "@/components/ui/AppBrand";

export default function Home() {
  return (
    <div className="login-bg flex min-h-screen flex-col items-center justify-center px-6">
      <div className="w-full max-w-md rounded-2xl border border-white/80 bg-white/90 p-10 text-center shadow-[0_24px_64px_-16px_rgba(15,23,42,0.12)] backdrop-blur-sm">
        <AppBrand size="lg" />
        <Link
          href="/login"
          className="mt-10 inline-flex w-full cursor-pointer items-center justify-center rounded-xl bg-pll-cyan py-3.5 text-sm font-semibold text-white shadow-[0_8px_24px_-6px_rgba(0,173,239,0.55)] transition-all hover:bg-pll-cyan-dark"
        >
          Go to Sign In
        </Link>
      </div>
    </div>
  );
}
