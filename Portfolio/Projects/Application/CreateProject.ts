import { IdGeneratorStrategy } from '../../Shared/Domain/IdGeneratorStrategy';
import { Timestamp } from '../../Shared/Domain/Timestamp';
import { SoftDelete } from '../../Shared/Domain/SoftDelete';
import { ProjectRepository } from '../Domain/ProjectRepository';
import { Project } from '../Domain/Project';
import { ProjectId } from '../Domain/ValueObject/ProjectId';
import { ProjectTitle } from '../Domain/ValueObject/ProjectTitle';
import { ProjectDescription } from '../Domain/ValueObject/ProjectDescription';
import { ProjectSlug } from '../Domain/ValueObject/ProjectSlug';
import { CreateProjectRequest } from './DTO/CreateProjectRequest';
import { IUseCase } from '../../Shared/Application/IUseCase';
import { Pinned } from '../../Shared/Domain/Pinned';

export class CreateProject
  implements IUseCase<CreateProjectRequest, Promise<Project>>
{
  private repository: ProjectRepository;
  private idGenerator: IdGeneratorStrategy;
  constructor(repository: ProjectRepository, idStrategy: IdGeneratorStrategy) {
    this.idGenerator = idStrategy;
    this.repository = repository;
  }

  async execute(arg: CreateProjectRequest): Promise<Project> {
    const project = Project.Create(
      ProjectId.create(this.idGenerator.generate()),
      ProjectTitle.create(arg.title),
      ProjectSlug.create(arg.title),
      ProjectDescription.create(arg.description),
      Pinned.create(arg.pinned),
      Timestamp.now(),
      SoftDelete.no(),
    );
    await this.repository.save(project);
    return project;
  }
}
