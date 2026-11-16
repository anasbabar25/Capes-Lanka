import { fieldClass } from "@/components/ui/FormInput";

type DateInputProps = {
  id: string;
  label: string;
  value: string;
  onChange: (value: string) => void;
  required?: boolean;
  min?: string;
  className?: string;
};

export default function DateInput({
  id,
  label,
  value,
  onChange,
  required = false,
  min,
  className = "",
}: DateInputProps) {
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
        type="date"
        required={required}
        min={min}
        value={value}
        onChange={(event) => onChange(event.target.value)}
        className={fieldClass}
      />
    </div>
  );
}
