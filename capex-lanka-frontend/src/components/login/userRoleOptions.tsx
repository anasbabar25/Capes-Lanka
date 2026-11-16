import {
  DirectorIcon,
  ExecutiveIcon,
  ManagerIcon,
  UserIcon,
} from "@/components/icons/RoleIcons";
import type { DropdownOption } from "@/components/ui/Dropdown";

export const USER_ROLES: DropdownOption[] = [
  {
    value: "user",
    label: "User",
    icon: <UserIcon />,
  },
  {
    value: "manager",
    label: "Manager/Incharge",
    icon: <ManagerIcon />,
  },
  {
    value: "bum-hod-hop-cfo",
    label: "BUM/HOD/HOP/CFO",
    icon: <ExecutiveIcon />,
  },
  {
    value: "managing-director",
    label: "Managing Director",
    icon: <DirectorIcon />,
  },
];
