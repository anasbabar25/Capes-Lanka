import { Injectable, UnauthorizedException } from '@nestjs/common';
import { ConfigService } from '@nestjs/config';
import { JwtService } from '@nestjs/jwt';
import * as bcrypt from 'bcryptjs';
import { User } from '../users/user.entity.js';
import { USER_ROLE_LABELS, UserRole } from '../users/user-role.enum.js';
import { UsersService } from '../users/users.service.js';
import { LoginDto } from './dto/login.dto.js';

@Injectable()
export class AuthService {
  constructor(
    private readonly usersService: UsersService,
    private readonly jwtService: JwtService,
    private readonly configService: ConfigService,
  ) {}

  async directory() {
    const users = await this.usersService.findDirectory();
    return users
      .filter((user) => Boolean(USER_ROLE_LABELS[user.role]))
      .map((user) => this.toPublicUser(user));
  }

  async login(dto: LoginDto) {
    const user = await this.usersService.findByUsername(dto.username);
    if (!user) {
      throw new UnauthorizedException('Invalid credentials');
    }

    const isPasswordValid = await bcrypt.compare(dto.password, user.password);
    if (!isPasswordValid) {
      throw new UnauthorizedException('Invalid credentials');
    }

    const payload = { sub: user.id, role: user.role };
    const accessToken = await this.jwtService.signAsync(payload);

    return {
      accessToken,
      user: this.toPublicUser(user),
    };
  }

  private loginRoleLabel(user: User) {
    const isLankaOnly = this.configService.get<boolean>('site.isLankaOnly') ?? true;
    if (isLankaOnly && user.role === UserRole.ORIGINATOR) {
      return 'User';
    }
    return USER_ROLE_LABELS[user.role];
  }

  private loginAccountName(user: User) {
    const withoutRoleSuffix = user.displayName.replace(/\s*\([^)]*\)\s*$/, '').trim();
    return withoutRoleSuffix || user.username;
  }

  toPublicUser(user: User) {
    return {
      id: user.id,
      username: user.username,
      role: user.role,
      displayName: user.displayName,
      loginAccountName: this.loginAccountName(user),
      roleLabel: this.loginRoleLabel(user),
      email: user.email,
      department: user.department
        ? {
            id: user.department.id,
            code: user.department.departmentCode,
            name: user.department.departmentName,
            allowsUnbudgetedRequests: user.department.allowsUnbudgetedRequests,
            allowsBudgetVirement: user.department.allowsBudgetVirement,
            isBudgetFrozen: user.department.isBudgetFrozen,
          }
        : null,
    };
  }
}
