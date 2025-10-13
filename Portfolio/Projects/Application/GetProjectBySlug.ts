import { IUseCase } from '../../Shared/Application/IUseCase';
import { Project } from '../Domain/Project';
import { ProjectRepository } from '../Domain/ProjectRepository';

export class GetProjectBySlug implements IUseCase<string, Promise<Project>> {
  private repository: ProjectRepository;

  constructor(repository: ProjectRepository) {
    this.repository = repository;
  }

  async execute(arg: string): Promise<Project> {
    const project = await this.repository.getBySlug(arg);
    if (project === null) throw new Error('Project not found');
    return project;
  }
}
