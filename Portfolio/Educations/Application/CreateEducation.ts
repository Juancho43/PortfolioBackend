import { IUseCase } from '../../Shared/Application/IUseCase';
import { Education } from '../Domain/Education';
import { EditEducationRequest } from './DTO/EditEducationRequest';
import { EducationRepository } from '../Domain/EducationRepository';
import { GetEducationById } from './GetEducationById';
import { EducationTitle } from '../Domain/ValueObject/EducationTitle';
import { EducationSlug } from '../Domain/ValueObject/EducationSlug';
import { EducationPeriod } from '../Domain/ValueObject/EducationPeriod';
import { EducationDescription } from '../Domain/ValueObject/EducationDescription';
import { CreateEducationRequest } from './DTO/CreateEducationRequest';
import { IdGeneratorStrategy } from '../../Shared/Domain/IdGeneratorStrategy';
import { EducationId } from '../Domain/ValueObject/EducationId';
import { Timestamp } from '../../Shared/Domain/Timestamp';
import { SoftDelete } from '../../Shared/Domain/SoftDelete';

export class CreateEducation
  implements IUseCase<CreateEducationRequest, Education>
{
  private repository: EducationRepository;
  private idGenerator: IdGeneratorStrategy;

  constructor(
    repository: EducationRepository,
    idGenerator: IdGeneratorStrategy,
  ) {
    this.repository = repository;
    this.idGenerator = idGenerator;
  }

  execute(arg: CreateEducationRequest): Education {

    const education = Education.create(
      EducationId.create(this.idGenerator.generate()),
      EducationTitle.create(arg.title),
      EducationDescription.create(arg.description),
      EducationPeriod.create(arg.startDate, arg.endDate),
      EducationSlug.create(arg.title),

      Timestamp.now(),
      SoftDelete.no(),
    );

    this.repository.save(education);
    return education;
  }
}
