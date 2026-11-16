import { Injectable } from '@nestjs/common';
import { ConfigService } from '@nestjs/config';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { LANKA_DEPARTMENT_CODES } from '../config/site.config.js';
import { User } from './user.entity.js';
import { UserRole } from './user-role.enum.js';

@Injectable()
export class UsersService {
  constructor(
    @InjectRepository(User)
    private readonly usersRepository: Repository<User>,
    private readonly configService: ConfigService,
  ) {}

  findByUsername(username: string) {
    return this.usersRepository
      .createQueryBuilder('user')
      .addSelect('user.password')
      .leftJoinAndSelect('user.department', 'department')
      .leftJoinAndSelect('user.reportsTo', 'reportsTo')
      .where('user.username = :username', { username })
      .andWhere('user.isActive = :active', { active: true })
      .getOne();
  }

  findById(id: number) {
    return this.usersRepository.findOne({
      where: { id },
      relations: { department: true, reportsTo: true },
    });
  }

  findByRole(role: UserRole) {
    return this.usersRepository.findOne({
      where: { role, isActive: true },
      relations: { department: true },
    });
  }

  findDirectory() {
    const isLankaOnly = this.configService.get<boolean>('site.isLankaOnly') ?? true;

    if (!isLankaOnly) {
      return this.usersRepository.find({
        where: { isActive: true },
        relations: { department: true },
        order: { displayName: 'ASC' },
      });
    }

    return this.usersRepository
      .createQueryBuilder('user')
      .leftJoinAndSelect('user.department', 'department')
      .where('user.isActive = :active', { active: true })
      .andWhere('department.departmentCode IN (:...codes)', {
        codes: [...LANKA_DEPARTMENT_CODES],
      })
      .orderBy('user.displayName', 'ASC')
      .getMany();
  }
}
