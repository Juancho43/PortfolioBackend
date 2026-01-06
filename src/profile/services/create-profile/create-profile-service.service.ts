import { Inject, Injectable } from '@nestjs/common';
import { CreateProfile } from 'Portfolio/Profile/Application/CreateProfile';
import { CreateProfileRequest } from 'Portfolio/Profile/Application/DTO/CreateProfileRequest';
import type { SaveProfileRepository } from 'Portfolio/Profile/Domain/SaveProfileRepository';

@Injectable()
export class CreateProfileService {
  private readonly createProfile: CreateProfile;
  constructor(
    @Inject('SaveProfileRepository')
    private readonly saveProfileRepository: SaveProfileRepository,
  ) {
    this.createProfile = new CreateProfile(this.saveProfileRepository);
  }

  async create(request: CreateProfileRequest) {
    return await this.createProfile.execute(request);
  }
}
