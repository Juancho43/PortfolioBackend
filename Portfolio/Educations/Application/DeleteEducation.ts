import { IUseCase } from '../../Shared/Application/IUseCase';
import { Education } from '../Domain/Education';
import { EducationRepository } from '../Domain/EducationRepository';
import { GetEducationById } from './GetEducationById';
import { DeleteEducationRequest } from './DTO/DeleteEducationRequest';

export class DeleteEducation
  implements IUseCase<DeleteEducationRequest, Promise<Education>>
{
  private repository: EducationRepository;
  private getEducationById: GetEducationById;

  constructor(
    repository: EducationRepository,
    getEducationById: GetEducationById,
  ) {
    this.repository = repository;
    this.getEducationById = getEducationById;
  }

  async execute(arg: DeleteEducationRequest): Promise<Education> {
    const education = this.getEducationById.execute(arg.educationId);
    await this.repository.delete(arg.educationId);
    return education;
  }
}
