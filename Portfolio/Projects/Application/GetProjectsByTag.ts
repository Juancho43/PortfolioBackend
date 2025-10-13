import { IUseCase } from '../../Shared/Application/IUseCase';
import { Paginated } from '../../Shared/Domain/Paginated';
import { Project } from '../Domain/Project';
import { ProjectRepository } from '../Domain/ProjectRepository';

export class GetProjectsByTag
  implements IUseCase<{ paginated: Paginated; tag: string }, Promise<Project[]>>
{
  private repository: ProjectRepository;
  constructor(repository: ProjectRepository) {
    this.repository = repository;
  }

  async execute(arg: {
    paginated: Paginated;
    tag: string;
  }): Promise<Project[]> {
    return await this.repository.getByTag(arg.paginated, arg.tag);
  }
}
