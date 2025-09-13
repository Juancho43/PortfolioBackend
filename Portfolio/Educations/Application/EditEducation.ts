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
  implements IUseCase<EditEducationRequest, Education>
{
  private repository: EducationRepository;
  private getEducationById: GetEducationById;

  execute(arg: EditEducationRequest): Education {
    const education = this.getEducationById.execute(arg.educationId);
    education.title = EducationTitle.create(arg.data.title);
    education.slug = EducationSlug.create(arg.data.title);
    education.peridod = EducationPeriod.create(
      arg.data.startDate,
      arg.data.endDate,
    );
    education.description = EducationDescription.create(arg.data.description);

    this.repository.save(education);
    return education;
  }
}
