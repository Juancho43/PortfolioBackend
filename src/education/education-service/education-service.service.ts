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

@Injectable()
export class EducationService {
  private getBySlug: GetEducationBySlug;
  private create: CreateEducation;
  private getAll: GetAllEducations;
  constructor(
    @Inject(EDUCATION_REPOSITORY_TOKEN)
    private readonly repository: EducationRepository,
    @Inject(ID_GENERATOR_TOKEN)
    private readonly generator: IdGeneratorStrategy,
  ) {
    this.create = new CreateEducation(this.repository, this.generator);
    this.getBySlug = new GetEducationBySlug(this.repository);
    this.getAll = new GetAllEducations(this.repository);
  }

  execute_getBySlug(slug: string): Education {
    return this.getBySlug.execute(slug);
  }
  async execute_create(data: CreateEducationRequest): Promise<Education> {
    const exampleEducation = new CreateEducationRequest(
      'Computer Science Degree',
      'Studied core computer science topics and software engineering.',
      '2018-09-01',
      '2022-06-30',
      [new CreateLinkRequest('hola','https://hola.com'), new CreateLinkRequest('holaaaa','https://holaaaa.com')],
      [],
      [],
    );
    return await this.create.execute(exampleEducation);
  }
  execute_getAll(page: string, limit: string): Promise<Education[]> {
    return this.getAll.execute({
      page: parseInt(page),
      limit: parseInt(limit),
    });
  }
}
