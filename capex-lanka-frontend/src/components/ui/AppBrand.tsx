import Image from "next/image";

type AppBrandProps = {
  showLogo?: boolean;
  size?: "sm" | "md" | "lg";
};

const sizeStyles = {
  sm: {
    logo: "h-14 w-14",
    title: "text-xl",
    subtitle: "text-xs",
  },
  md: {
    logo: "h-[88px] w-[88px]",
    title: "text-2xl",
    subtitle: "text-sm",
  },
  lg: {
    logo: "h-24 w-24",
    title: "text-3xl",
    subtitle: "text-base",
  },
};

export default function AppBrand({ showLogo = true, size = "md" }: AppBrandProps) {
  const styles = sizeStyles[size];

  return (
    <div className="flex flex-col items-center text-center">
      {showLogo && (
        <div
          className={`relative mb-5 overflow-hidden rounded-2xl shadow-[0_8px_32px_-8px_rgba(0,173,239,0.35)] ring-1 ring-pll-cyan/20 ${styles.logo}`}
        >
          <Image
            src="/PLL-logo.jpeg"
            alt="Capex Lanka logo"
            fill
            className="object-cover"
            priority
          />
        </div>
      )}
      <h1
        className={`font-semibold tracking-tight text-pll-black ${styles.title}`}
      >
        Capex Lanka
      </h1>
      <p className={`mt-1.5 font-medium tracking-wide text-pll-cyan ${styles.subtitle}`}>
        Capital Expenditure Proposal
      </p>
    </div>
  );
}
