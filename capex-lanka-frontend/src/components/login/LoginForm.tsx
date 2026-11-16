"use client";

import { FormEvent, useEffect, useMemo, useState } from "react";
import { useRouter } from "next/navigation";
import Dropdown, { type DropdownOption } from "@/components/ui/Dropdown";
import {
  DirectorIcon,
  ExecutiveIcon,
  ManagerIcon,
  UserIcon,
} from "@/components/icons/RoleIcons";
import { apiFetch } from "@/lib/api";
import { setAuth } from "@/lib/auth";
import type { DirectoryUser, LoginResponse } from "@/types/auth";

function roleIcon(role: string) {
  if (role === "managing-director" || role === "cfo") return <DirectorIcon />;
  if (
    role.startsWith("head-of") ||
    role.startsWith("group-head") ||
    role === "financial-controller" ||
    role === "bum"
  ) {
    return <ExecutiveIcon />;
  }
  if (role === "hod" || role === "business-controller") return <ManagerIcon />;
  return <UserIcon />;
}

export default function LoginForm() {
  const router = useRouter();
  const [directory, setDirectory] = useState<DirectoryUser[]>([]);
  const [username, setUsername] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
  const [isLoading, setIsLoading] = useState(false);

  useEffect(() => {
    apiFetch<DirectoryUser[]>("/auth/directory")
      .then(setDirectory)
      .catch(() => setDirectory([]));
  }, []);

  const options: DropdownOption[] = useMemo(
    () =>
      directory
        .slice()
        .sort((left, right) => {
          if (left.role === "originator") return -1;
          if (right.role === "originator") return 1;
          return (left.loginAccountName ?? left.displayName).localeCompare(
            right.loginAccountName ?? right.displayName,
          );
        })
        .map((user) => ({
          value: user.username,
          label: `${user.loginAccountName ?? user.displayName} — ${user.roleLabel}`,
          icon: roleIcon(user.role),
        })),
    [directory],
  );

  async function handleSubmit(event: FormEvent<HTMLFormElement>) {
    event.preventDefault();
    setError("");
    setIsLoading(true);

    try {
      const response = await apiFetch<LoginResponse>("/auth/login", {
        method: "POST",
        body: JSON.stringify({ username, password }),
      });

      setAuth(response.accessToken, response.user);
      router.push("/dashboard");
    } catch (err) {
      setError(err instanceof Error ? err.message : "Login failed");
    } finally {
      setIsLoading(false);
    }
  }

  return (
    <form onSubmit={handleSubmit} className="space-y-5">
      {error && (
        <div className="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-600">
          {error}
        </div>
      )}

      <Dropdown
        id="username"
        name="username"
        label="User"
        placeholder="Select user"
        value={username}
        onChange={setUsername}
        options={options}
        required
      />

      <div className="space-y-2">
        <div className="flex items-center justify-between">
          <label
            htmlFor="password"
            className="block text-sm font-medium tracking-wide text-slate-600"
          >
            Password
          </label>
          <span className="text-xs font-medium text-slate-400">legacy password</span>
        </div>
        <input
          id="password"
          name="password"
          type="password"
          autoComplete="current-password"
          required
          value={password}
          onChange={(event) => setPassword(event.target.value)}
          placeholder="Enter your password"
          className="w-full rounded-xl border border-slate-200 bg-slate-50/60 px-4 py-3 text-sm text-slate-900 outline-none transition-all placeholder:text-slate-400 focus:border-pll-cyan focus:bg-white focus:ring-4 focus:ring-pll-cyan/15"
        />
      </div>

      <button
        type="submit"
        disabled={isLoading}
        className="relative w-full overflow-hidden rounded-xl bg-pll-cyan py-3.5 text-sm font-semibold tracking-wide text-white shadow-[0_8px_24px_-6px_rgba(0,173,239,0.55)] transition-all hover:bg-pll-cyan-dark hover:shadow-[0_12px_28px_-8px_rgba(0,173,239,0.6)] active:scale-[0.99] disabled:cursor-not-allowed disabled:opacity-70"
      >
        {isLoading ? (
          <span className="flex items-center justify-center gap-2">
            <span className="h-4 w-4 animate-spin rounded-full border-2 border-white/30 border-t-white" />
            Signing in...
          </span>
        ) : (
          "Sign in"
        )}
      </button>
    </form>
  );
}
