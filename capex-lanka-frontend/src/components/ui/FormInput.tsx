type FormInputProps = {
  id: string;
  label: string;
  type?: string;
  value: string;
  onChange: (value: string) => void;
  placeholder?: string;
  required?: boolean;
  readOnly?: boolean;
  minLength?: number;
  className?: string;
};

const fieldClass =
  "w-full rounded-lg border border-slate-200/90 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition-all placeholder:text-slate-400 focus:border-pll-cyan focus:ring-2 focus:ring-pll-cyan/15";

export default function FormInput({
  id,
  label,
  type = "text",
  value,
  onChange,
  placeholder,
  required = false,
  readOnly = false,
  minLength,
  className = "",
}: FormInputProps) {
  return (
    <div className={`space-y-1.5 ${className}`}>
      <label
        htmlFor={id}
        className="block text-xs font-medium tracking-wide text-slate-500"
      >
        {label}
      </label>
      <input
        id={id}
        name={id}
        type={type}
        required={required}
        readOnly={readOnly}
        minLength={minLength}
        value={value}
        onChange={(event) => onChange(event.target.value)}
        placeholder={placeholder}
        className={`${fieldClass} ${
          readOnly
            ? "cursor-not-allowed border-slate-100 bg-slate-50 text-slate-500"
            : ""
        }`}
      />
    </div>
  );
}

export { fieldClass };
