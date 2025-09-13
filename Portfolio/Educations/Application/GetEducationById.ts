import { EducationRepository } from '../Domain/EducationRepository';
import { IUseCase } from '../../Shared/Application/IUseCase';
import { Education } from '../Domain/Education';

export class GetEducationById implements IUseCase<string, Education> {
  private repository: EducationRepository;

  execute(arg: string): Education {
    const education = this.repository.getById(arg);
    if (education === null) throw new Error('Education not found');
    return education;
  }
}
