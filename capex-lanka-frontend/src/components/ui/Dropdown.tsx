"use client";

import {
  useCallback,
  useEffect,
  useId,
  useRef,
  useState,
  type KeyboardEvent,
  type ReactNode,
} from "react";

export type DropdownOption = {
  value: string;
  label: string;
  icon?: ReactNode;
};

export type DropdownProps = {
  id?: string;
  name?: string;
  label?: string;
  placeholder?: string;
  value: string;
  onChange: (value: string) => void;
  options: DropdownOption[];
  required?: boolean;
  disabled?: boolean;
  error?: string;
  className?: string;
};

function OptionIcon({
  icon,
  selected = false,
  highlighted = false,
}: {
  icon: ReactNode;
  selected?: boolean;
  highlighted?: boolean;
}) {
  return (
    <span
      className={`flex h-8 w-8 shrink-0 items-center justify-center rounded-lg transition-colors ${
        selected
          ? "bg-white/80 text-pll-cyan"
          : highlighted
            ? "bg-pll-cyan-light text-pll-cyan"
            : "bg-slate-100 text-slate-500"
      }`}
    >
      {icon}
    </span>
  );
}

function ChevronIcon({ open }: { open: boolean }) {
  return (
    <svg
      aria-hidden
      viewBox="0 0 20 20"
      fill="none"
      className={`h-4 w-4 shrink-0 text-slate-400 transition-transform duration-200 ${open ? "rotate-180" : ""}`}
    >
      <path
        d="M5 7.5L10 12.5L15 7.5"
        stroke="currentColor"
        strokeWidth="1.75"
        strokeLinecap="round"
        strokeLinejoin="round"
      />
    </svg>
  );
}

export default function Dropdown({
  id: idProp,
  name,
  label,
  placeholder = "Select an option",
  value,
  onChange,
  options,
  required = false,
  disabled = false,
  error,
  className = "",
}: DropdownProps) {
  const generatedId = useId();
  const id = idProp ?? generatedId;
  const listboxId = `${id}-listbox`;

  const containerRef = useRef<HTMLDivElement>(null);
  const triggerRef = useRef<HTMLButtonElement>(null);
  const [isOpen, setIsOpen] = useState(false);
  const [highlightedIndex, setHighlightedIndex] = useState(-1);

  const selectedOption = options.find((option) => option.value === value);
  const displayLabel = selectedOption?.label ?? placeholder;
  const hasValue = Boolean(selectedOption);

  const close = useCallback(() => {
    setIsOpen(false);
    setHighlightedIndex(-1);
  }, []);

  const open = useCallback(() => {
    if (disabled) return;

    const selectedIndex = options.findIndex((option) => option.value === value);
    setHighlightedIndex(selectedIndex >= 0 ? selectedIndex : 0);
    setIsOpen(true);
  }, [disabled, options, value]);

  const selectOption = useCallback(
    (option: DropdownOption) => {
      onChange(option.value);
      close();
      triggerRef.current?.focus();
    },
    [close, onChange],
  );

  useEffect(() => {
    if (!isOpen) return;

    function handlePointerDown(event: MouseEvent) {
      if (!containerRef.current?.contains(event.target as Node)) {
        close();
      }
    }

    function handleKeyDown(event: globalThis.KeyboardEvent) {
      if (event.key === "Escape") {
        close();
        triggerRef.current?.focus();
      }
    }

    document.addEventListener("mousedown", handlePointerDown);
    document.addEventListener("keydown", handleKeyDown);

    return () => {
      document.removeEventListener("mousedown", handlePointerDown);
      document.removeEventListener("keydown", handleKeyDown);
    };
  }, [close, isOpen]);

  function handleTriggerKeyDown(event: KeyboardEvent<HTMLButtonElement>) {
    if (disabled) return;

    switch (event.key) {
      case "ArrowDown":
      case "ArrowUp":
      case "Enter":
      case " ":
        event.preventDefault();
        if (!isOpen) {
          open();
        } else if (event.key === "ArrowDown") {
          setHighlightedIndex((current) =>
            current < options.length - 1 ? current + 1 : 0,
          );
        } else if (event.key === "ArrowUp") {
          setHighlightedIndex((current) =>
            current > 0 ? current - 1 : options.length - 1,
          );
        } else if (
          (event.key === "Enter" || event.key === " ") &&
          highlightedIndex >= 0
        ) {
          selectOption(options[highlightedIndex]);
        }
        break;
      case "Escape":
        event.preventDefault();
        close();
        break;
      default:
        break;
    }
  }

  function handleListboxKeyDown(event: KeyboardEvent<HTMLUListElement>) {
    switch (event.key) {
      case "ArrowDown":
        event.preventDefault();
        setHighlightedIndex((current) =>
          current < options.length - 1 ? current + 1 : 0,
        );
        break;
      case "ArrowUp":
        event.preventDefault();
        setHighlightedIndex((current) =>
          current > 0 ? current - 1 : options.length - 1,
        );
        break;
      case "Enter":
      case " ":
        event.preventDefault();
        if (highlightedIndex >= 0) {
          selectOption(options[highlightedIndex]);
        }
        break;
      case "Escape":
        event.preventDefault();
        close();
        triggerRef.current?.focus();
        break;
      case "Tab":
        close();
        break;
      default:
        break;
    }
  }

  return (
    <div ref={containerRef} className={`relative space-y-1.5 ${className}`}>
      {label && (
        <label
          htmlFor={id}
          className="block text-xs font-medium tracking-wide text-slate-500"
        >
          {label}
        </label>
      )}

      {name && (
        <input
          type="hidden"
          name={name}
          value={value}
          required={required}
          tabIndex={-1}
          aria-hidden
        />
      )}

      <button
        ref={triggerRef}
        id={id}
        type="button"
        role="combobox"
        aria-controls={listboxId}
        aria-expanded={isOpen}
        aria-haspopup="listbox"
        aria-invalid={Boolean(error)}
        disabled={disabled}
        onClick={() => (isOpen ? close() : open())}
        onKeyDown={handleTriggerKeyDown}
        className={`flex w-full items-center justify-between gap-2 rounded-lg border bg-white px-3 py-2.5 text-left text-sm outline-none transition-all ${
          error
            ? "border-red-300 focus:border-red-400 focus:ring-2 focus:ring-red-100"
            : isOpen
              ? "border-pll-cyan ring-2 ring-pll-cyan/15"
              : "border-slate-200/90 hover:border-slate-300 focus:border-pll-cyan focus:ring-2 focus:ring-pll-cyan/15"
        } ${disabled ? "cursor-not-allowed opacity-60" : ""}`}
      >
        <span className="flex min-w-0 items-center gap-2.5">
          {selectedOption?.icon && (
            <OptionIcon icon={selectedOption.icon} selected />
          )}
          <span
            className={`truncate ${hasValue ? "text-slate-900" : "text-slate-400"}`}
          >
            {displayLabel}
          </span>
        </span>
        <ChevronIcon open={isOpen} />
      </button>

      {isOpen && (
        <ul
          id={listboxId}
          role="listbox"
          aria-labelledby={id}
          tabIndex={-1}
          onKeyDown={handleListboxKeyDown}
          className="absolute z-50 mt-2 max-h-60 w-full overflow-auto rounded-xl border border-slate-200 bg-white p-1.5 shadow-[0_16px_40px_-12px_rgba(15,23,42,0.18)]"
        >
          {options.map((option, index) => {
            const isSelected = option.value === value;
            const isHighlighted = index === highlightedIndex;

            return (
              <li
                key={option.value}
                role="option"
                aria-selected={isSelected}
                onMouseEnter={() => setHighlightedIndex(index)}
                onClick={() => selectOption(option)}
                className={`cursor-pointer rounded-lg px-3 py-2.5 text-sm transition-colors ${
                  isSelected
                    ? "bg-pll-cyan-light font-medium text-pll-cyan-dark"
                    : isHighlighted
                      ? "bg-slate-50 text-slate-900"
                      : "text-slate-700 hover:bg-slate-50"
                }`}
              >
                <span className="flex items-center justify-between gap-3">
                  <span className="flex min-w-0 items-center gap-3">
                    {option.icon && (
                      <OptionIcon
                        icon={option.icon}
                        selected={isSelected}
                        highlighted={isHighlighted}
                      />
                    )}
                    <span className="truncate">{option.label}</span>
                  </span>
                  {isSelected && (
                    <svg
                      aria-hidden
                      viewBox="0 0 20 20"
                      fill="none"
                      className="h-4 w-4 shrink-0 text-pll-cyan"
                    >
                      <path
                        d="M5 10L8.5 13.5L15 7"
                        stroke="currentColor"
                        strokeWidth="1.75"
                        strokeLinecap="round"
                        strokeLinejoin="round"
                      />
                    </svg>
                  )}
                </span>
              </li>
            );
          })}
        </ul>
      )}

      {error && <p className="text-xs text-red-500">{error}</p>}
    </div>
  );
}
