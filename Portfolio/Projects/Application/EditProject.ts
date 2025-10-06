import { IdGeneratorStrategy } from '../../Shared/Domain/IdGeneratorStrategy';
import { Timestamp } from '../../Shared/Domain/Timestamp';
import { SoftDelete } from '../../Shared/Domain/SoftDelete';
import { ProjectRepository } from '../Domain/ProjectRepository';
import { Project } from '../Domain/Project';
import { SlugValueObject } from '../../Shared/Domain/SlugValueObject';
import { ProjectId } from '../Domain/ValueObject/ProjectId';
import { Link } from '../../Links/Domain/Link';
import { Tag } from '../../Tags/Domain/Tag';
import { ProjectTitle } from '../Domain/ValueObject/ProjectTitle';
import { ProjectDescription } from '../Domain/ValueObject/ProjectDescription';
import { ProjectSlug } from '../Domain/ValueObject/ProjectSlug';

export class CreateProject {
  private repository: ProjectRepository;
  private idGenerator: IdGeneratorStrategy;
  constructor(repository: ProjectRepository, idStrategy: IdGeneratorStrategy) {
    this.idGenerator = idStrategy;
    this.repository = repository;
  }

  execute(
    title: string,
    description: string,
    links: Link[],
    tags: Tag[],
  ): Project {
    const project = Project.Create(
      ProjectId.create(this.idGenerator.generate()),
      ProjectTitle.create(title),
      ProjectSlug.create(SlugValueObject.create(title)),
      ProjectDescription.create(description),
      links,
      tags,
      Timestamp.now(),
      SoftDelete.no(),
    );
    this.repository.save(project);
    return project;
  }
}
