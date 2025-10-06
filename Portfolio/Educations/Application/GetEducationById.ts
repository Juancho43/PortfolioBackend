import { EducationRepository } from '../Domain/EducationRepository';
import { IUseCase } from '../../Shared/Application/IUseCase';
import { Education } from '../Domain/Education';

export class GetEducationById implements IUseCase<string, Promise<Education>> {
  private repository: EducationRepository;

  constructor(repository: EducationRepository) {
    this.repository = repository;
  }
  async execute(arg: string): Promise<Education> {
    const education = await this.repository.getById(arg);
    if (education === null) throw new Error('Education not found');
    return education;
  }
}
