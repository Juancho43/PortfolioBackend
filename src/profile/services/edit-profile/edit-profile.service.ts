import { Inject, Injectable } from '@nestjs/common';
import { EditProfile } from '../../../../Portfolio/Profile/Application/EditProfile';
import type { SaveProfileRepository } from '../../../../Portfolio/Profile/Domain/SaveProfileRepository';
import { GetProfileService } from '../get-profile/get-profile.service';
import { EditProfileRequest } from '../../../../Portfolio/Profile/Application/DTO/EditProfileRequest';

@Injectable()
export class EditProfileService {
  private readonly editProfile: EditProfile;

  constructor(
    @Inject('SaveProfileRepository')
    private readonly saveProfileRepository: SaveProfileRepository,
    @Inject()
    private readonly getProfileService: GetProfileService,
  ) {
    this.editProfile = new EditProfile(
      this.getProfileService.getProfile,
      this.saveProfileRepository,
    );
  }
  async execute(request: EditProfileRequest) {
    return await this.editProfile.execute(request);
  }
}
