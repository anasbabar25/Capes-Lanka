import Image from "next/image";

type PoweredByFooterProps = {
  className?: string;
};

export default function PoweredByFooter({ className = "" }: PoweredByFooterProps) {
  return (
    <div
      className={`flex flex-col items-center gap-4 ${className}`}
    >
      <div className="flex flex-col items-center gap-2 sm:flex-row sm:gap-3">
        <span className="text-xs font-medium tracking-wide text-slate-400">
          Powered by
        </span>
        <Image
          src="/packages-group-02.png"
          alt="Packages Group"
          width={160}
          height={56}
          className="h-10 w-auto object-contain"
        />
      </div>
      <p className="text-center text-xs text-slate-400">
        &copy; {new Date().getFullYear()} Capex Lanka. All rights reserved.
      </p>
    </div>
  );
}
