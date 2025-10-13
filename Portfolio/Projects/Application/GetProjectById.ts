import { IUseCase } from '../../Shared/Application/IUseCase';
import { Project } from '../Domain/Project';
import { ProjectRepository } from '../Domain/ProjectRepository';

export class GetProjectById implements IUseCase<string, Promise<Project>> {
  private repository: ProjectRepository;

  constructor(repository: ProjectRepository) {
    this.repository = repository;
  }

  async execute(arg: string): Promise<Project> {
    const education = await this.repository.getById(arg);
    if (education === null) throw new Error('Education not found');
    return education;
  }
}
