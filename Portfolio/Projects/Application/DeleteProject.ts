import { IUseCase } from '../../Shared/Application/IUseCase';
import { GetProjectById } from './GetProjectById';
import { ProjectRepository } from '../Domain/ProjectRepository';
import { Project } from '../Domain/Project';
import { DeleteProjectRequest } from './DTO/DeleteProjectRequest';

export class DeleteProject
  implements IUseCase<DeleteProjectRequest, Promise<Project>>
{
  private repository: ProjectRepository;
  private getById: GetProjectById;

  constructor(repository: ProjectRepository, getById: GetProjectById) {
    this.repository = repository;
    this.getById = getById;
  }

  async execute(arg: DeleteProjectRequest): Promise<Project> {
    const education = this.getById.execute(arg.projectId);
    this.repository.delete(arg.projectId);
    return education;
  }
}
