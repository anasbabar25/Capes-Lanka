import { Injectable } from '@nestjs/common';
import { ConfigService } from '@nestjs/config';
import { InjectRepository } from '@nestjs/typeorm';
import { In, Repository } from 'typeorm';
import { LANKA_DEPARTMENT_CODES } from '../config/site.config.js';
import { Department } from './department.entity.js';

@Injectable()
export class OrganizationService {
  constructor(
    @InjectRepository(Department)
    private readonly departmentRepository: Repository<Department>,
    private readonly configService: ConfigService,
  ) {}

  findAll() {
    const isLankaOnly = this.configService.get<boolean>('site.isLankaOnly') ?? true;

    return this.departmentRepository.find({
      where: {
        isActive: true,
        ...(isLankaOnly ? { departmentCode: In([...LANKA_DEPARTMENT_CODES]) } : {}),
      },
      order: { departmentCode: 'ASC' },
    });
  }

  findByCode(departmentCode: string) {
    return this.departmentRepository.findOne({ where: { departmentCode } });
  }

  findById(id: number) {
    return this.departmentRepository.findOne({ where: { id } });
  }
}
