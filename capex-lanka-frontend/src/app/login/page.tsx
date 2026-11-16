import AppBrand from "@/components/ui/AppBrand";
import LoginForm from "@/components/login/LoginForm";
import PoweredByFooter from "@/components/ui/PoweredByFooter";

export default function LoginPage() {
  return (
    <div className="login-bg relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-12">
      {/* Decorative brand triangles */}
      <div
        aria-hidden
        className="login-triangle pointer-events-none absolute -left-16 top-24 h-48 w-48 bg-pll-cyan/8"
      />
      <div
        aria-hidden
        className="login-triangle pointer-events-none absolute -right-20 bottom-16 h-64 w-64 bg-pll-cyan/6"
      />
      <div
        aria-hidden
        className="pointer-events-none absolute left-1/2 top-0 h-[420px] w-[420px] -translate-x-1/2 -translate-y-1/2 rounded-full bg-pll-cyan/5 blur-3xl"
      />

      <div className="relative w-full max-w-[440px]">
        <div className="rounded-2xl border border-white/80 bg-white/90 p-8 shadow-[0_24px_64px_-16px_rgba(15,23,42,0.12)] backdrop-blur-sm sm:p-10">
          <div className="mb-8">
            <AppBrand />
            <p className="mt-5 text-center text-sm leading-relaxed text-slate-500">
              Sign in to your account to continue
            </p>
          </div>

          <LoginForm />

          <p className="mt-8 text-center text-xs text-slate-400">
            Protected by enterprise-grade security
          </p>
        </div>

        <PoweredByFooter className="mt-6" />
      </div>
    </div>
  );
}
