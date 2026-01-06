import { IUseCase } from 'Portfolio/Shared/Application/IUseCase';
import { Profile } from '../Domain/Profile';
import type { GetProfileRepository } from '../Domain/GetProfileRepository';

export class GetProfileById implements IUseCase<string, Promise<Profile>> {
  constructor(private readonly getProfileRepository: GetProfileRepository) {}

  async execute(id: string): Promise<Profile> {
    const profile = await this.getProfileRepository.getById(id);
    if (!profile) {
      throw new Error('Profile not found');
    }
    return profile;
  }
}
