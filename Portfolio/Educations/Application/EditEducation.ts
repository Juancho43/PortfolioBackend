import { IUseCase } from '../../Shared/Application/IUseCase';
import { Education } from '../Domain/Education';
import { EditEducationRequest } from './DTO/EditEducationRequest';
import { EducationRepository } from '../Domain/EducationRepository';
import { GetEducationById } from './GetEducationById';
import { EducationTitle } from '../Domain/ValueObject/EducationTitle';
import { EducationSlug } from '../Domain/ValueObject/EducationSlug';
import { EducationPeriod } from '../Domain/ValueObject/EducationPeriod';
import { EducationDescription } from '../Domain/ValueObject/EducationDescription';

export class EditEducation
  implements IUseCase<EditEducationRequest, Promise<Education>>
{
  private repository: EducationRepository;
  private getEducationById: GetEducationById;

  constructor(
    repository: EducationRepository,
    getEducationById: GetEducationById,
  ) {
    this.repository = repository;
    this.getEducationById = getEducationById;
  }

  async execute(arg: EditEducationRequest): Promise<Education> {
    const education = this.getEducationById.execute(arg.educationId);
    education.title = EducationTitle.create(arg.data.title);
    education.slug = EducationSlug.create(arg.data.title);
    education.peridod = EducationPeriod.create(
      arg.data.startDate,
      arg.data.endDate,
    );
    education.description = EducationDescription.create(arg.data.description);

    await this.repository.save(education);
    return education;
  }
}
