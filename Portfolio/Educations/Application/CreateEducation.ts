import { IUseCase } from '../../Shared/Application/IUseCase';
import { Education } from '../Domain/Education';
import { EducationRepository } from '../Domain/EducationRepository';
import { EducationTitle } from '../Domain/ValueObject/EducationTitle';
import { EducationSlug } from '../Domain/ValueObject/EducationSlug';
import { EducationPeriod } from '../Domain/ValueObject/EducationPeriod';
import { EducationDescription } from '../Domain/ValueObject/EducationDescription';
import { CreateEducationRequest } from './DTO/CreateEducationRequest';
import { IdGeneratorStrategy } from '../../Shared/Domain/IdGeneratorStrategy';
import { EducationId } from '../Domain/ValueObject/EducationId';
import { Timestamp } from '../../Shared/Domain/Timestamp';
import { SoftDelete } from '../../Shared/Domain/SoftDelete';
import { Link } from '../../Links/Domain/Link';
import { LinkTitle } from '../../Links/Domain/ValueObject/LinkTitle';
import { LinkId } from '../../Links/Domain/ValueObject/LinkId';
import { LinkUrl } from '../../Links/Domain/ValueObject/LinkUrl';

export class CreateEducation
  implements IUseCase<CreateEducationRequest, Promise<Education>>
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

  async execute(arg: CreateEducationRequest): Promise<Education> {
    const education = Education.create(
      EducationId.create(this.idGenerator.generate()),
      EducationTitle.create(arg.title),
      EducationDescription.create(arg.description),
      EducationPeriod.create(arg.startDate, arg.endDate),
      EducationSlug.create(arg.title),

      Timestamp.now(),
      SoftDelete.no(),
    );
    education.links = arg.links.map((newLink) =>
      Link.create(
        LinkId.create(this.idGenerator.generate()),
        LinkTitle.create(newLink.title),
        LinkUrl.create(newLink.url),
        Timestamp.now(),
        SoftDelete.no(),
      ),
    );
    console.log(education.links);
    await this.repository.save(education);
    return education;
  }
}
