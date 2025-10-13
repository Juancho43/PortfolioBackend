import { IUseCase } from '../../Shared/Application/IUseCase';
import { Paginated } from '../../Shared/Domain/Paginated';
import { Project } from '../Domain/Project';
import { ProjectRepository } from '../Domain/ProjectRepository';

export class GetAllProjects implements IUseCase<Paginated, Promise<Project[]>> {
  private repository: ProjectRepository;
  constructor(repository: ProjectRepository) {
    this.repository = repository;
  }

  async execute(arg: Paginated): Promise<Project[]> {
    return await this.repository.getAll(arg.page, arg.limit);
  }
}
