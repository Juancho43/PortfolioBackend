import { IUseCase } from '../../Shared/Application/IUseCase';
import { Education } from '../Domain/Education';
import { EducationRepository } from '../Domain/EducationRepository';
import { Paginated } from '../../Shared/Domain/Paginated';

export class GetAllEducations
  implements IUseCase<Paginated, Promise<Education[]>>
{
  private repository: EducationRepository;

  constructor(repository: EducationRepository) {
    this.repository = repository;
  }

  async execute(arg: Paginated): Promise<Education[]> {
    return await this.repository.getAll(arg.page, arg.limit);
  }
}
