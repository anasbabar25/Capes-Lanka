import type { DropdownOption } from "@/components/ui/Dropdown";

export const BUDGETED_OPTIONS: DropdownOption[] = [
  { value: "yes", label: "Yes" },
  { value: "strategic", label: "Strategic" },
  { value: "no", label: "No" },
];

export const REPLACEMENT_EXPANSION_OPTIONS: DropdownOption[] = [
  { value: "replacement", label: "Replacement" },
  { value: "expansion", label: "Expansion" },
];

export const CATEGORY_OPTIONS: DropdownOption[] = [
  { value: "building", label: "Building" },
  { value: "entitlements", label: "Entitlements" },
  { value: "heavy-vehicles", label: "Heavy Vehicles" },
  { value: "it-equipments", label: "IT Equipments" },
  { value: "land", label: "Land" },
  { value: "other-equipment", label: "Other Equipment" },
  { value: "plant-and-machinery", label: "Plant and Machinery" },
];

export const YES_NO_OPTIONS: DropdownOption[] = [
  { value: "yes", label: "Yes" },
  { value: "no", label: "No" },
];
