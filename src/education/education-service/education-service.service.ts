import { Inject, Injectable } from '@nestjs/common';
import { GetEducationBySlug } from '../../../Portfolio/Educations/Application/GetEducationBySlug';
import type { EducationRepository } from '../../../Portfolio/Educations/Domain/EducationRepository';
import { Education } from '../../../Portfolio/Educations/Domain/Education';
import { EDUCATION_REPOSITORY_TOKEN } from '../Mongoose/education.constansts';
import { CreateEducation } from '../../../Portfolio/Educations/Application/CreateEducation';
import type { IdGeneratorStrategy } from '../../../Portfolio/Shared/Domain/IdGeneratorStrategy';
import { ID_GENERATOR_TOKEN } from '../../id-strategies/token';
import { CreateEducationRequest } from '../../../Portfolio/Educations/Application/DTO/CreateEducationRequest';
import { GetAllEducations } from '../../../Portfolio/Educations/Application/GetAllEducations';
import { CreateLinkRequest } from '../../../Portfolio/Links/Application/CreateLinkRequest';
import { GetEducationById } from '../../../Portfolio/Educations/Application/GetEducationById';
import { EditEducation } from '../../../Portfolio/Educations/Application/EditEducation';
import { EditEducationRequest } from '../../../Portfolio/Educations/Application/DTO/EditEducationRequest';
import { DeleteEducation } from '../../../Portfolio/Educations/Application/DeleteEducation';
import { DeleteEducationRequest } from '../../../Portfolio/Educations/Application/DTO/DeleteEducationRequest';

@Injectable()
export class EducationService {
  private getBySlug: GetEducationBySlug;
  private create: CreateEducation;
  private getAll: GetAllEducations;
  private readonly getById: GetEducationById;
  private edit: EditEducation;
  private delete: DeleteEducation;
  constructor(
    @Inject(EDUCATION_REPOSITORY_TOKEN)
    private readonly repository: EducationRepository,
    @Inject(ID_GENERATOR_TOKEN)
    private readonly generator: IdGeneratorStrategy,
  ) {
    this.create = new CreateEducation(this.repository, this.generator);
    this.getBySlug = new GetEducationBySlug(this.repository);
    this.getAll = new GetAllEducations(this.repository);
    this.getById = new GetEducationById(this.repository);
    this.edit = new EditEducation(this.repository, this.getById);
    this.delete = new DeleteEducation(this.repository, this.getById);
  }

  async execute_getBySlug(slug: string): Promise<Education> {
    return await this.getBySlug.execute(slug);
  }
  async execute_create(data: CreateEducationRequest): Promise<Education> {
    return await this.create.execute(data);
  }
  execute_getAll(page: string, limit: string): Promise<Education[]> {
    return this.getAll.execute({
      page: parseInt(page),
      limit: parseInt(limit),
    });
  }
  async execute_delete(data: DeleteEducationRequest): Promise<Education> {
    return await this.delete.execute(data);
  }
  async execute_update(data: EditEducationRequest): Promise<Education> {
    return await this.edit.execute(data);
  }
  async execute_getById(id: string): Promise<Education> {
    return await this.getById.execute(id);
  }
}
