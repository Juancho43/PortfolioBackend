import { ProjectRepository } from '../Domain/ProjectRepository';
import { Project } from '../Domain/Project';
import { SlugValueObject } from '../../Shared/Domain/SlugValueObject';
import { ProjectTitle } from '../Domain/ValueObject/ProjectTitle';
import { ProjectDescription } from '../Domain/ValueObject/ProjectDescription';
import { ProjectSlug } from '../Domain/ValueObject/ProjectSlug';
import { GetProjectById } from './GetProjectById';
import { IUseCase } from '../../Shared/Application/IUseCase';
import { EditProjectRequest } from './DTO/EditProjectRequest';

export class EditProject
  implements IUseCase<EditProjectRequest, Promise<Project>>
{
  private repository: ProjectRepository;
  private getById: GetProjectById;
  constructor(repository: ProjectRepository, getProjectById: GetProjectById) {
    this.getById = getProjectById;
    this.repository = repository;
  }

  async execute(arg: EditProjectRequest): Promise<Project> {
    const project = await this.getById.execute(arg.projectId);
    project.title = ProjectTitle.create(arg.data.title);
    project.slug = ProjectSlug.create(arg.data.title);
    project.description = ProjectDescription.create(arg.data.description);
    project.links = arg.data.links;
    project.tags = arg.data.tags;
    project.timestamp = project.timestamp.touch();
    await this.repository.save(project);
    return project;
  }
}
