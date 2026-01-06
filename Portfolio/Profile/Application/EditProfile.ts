import { IUseCase } from '../../Shared/Application/IUseCase';
import { Profile } from '../Domain/Profile';
import { EditProfileRequest } from './DTO/EditProfileRequest';
import { SaveProfileRepository } from '../Domain/SaveProfileRepository';
import { ProfileName } from '../Domain/ValueObjects/ProfileName';
import { ProfileRole } from '../Domain/ValueObjects/ProfileRol';
import { ProfileBio } from '../Domain/ValueObjects/ProfileBio';
import { ProfileDescription } from '../Domain/ValueObjects/ProfileDescription';
import { GetProfileById } from './GetProfileById';

export class EditProfile
  implements IUseCase<EditProfileRequest, Promise<Profile>>
{
  constructor(
    private readonly getProfile: GetProfileById,
    private readonly saveProfileRepository: SaveProfileRepository,
  ) {}

  async execute(arg: EditProfileRequest): Promise<Profile> {
    const profile = await this.getProfile.execute(arg.id);
    profile.name = ProfileName.create(arg.data.name);
    profile.rol = ProfileRole.create(arg.data.role);
    profile.bio = ProfileBio.create(arg.data.bio);
    profile.description = ProfileDescription.create(arg.data.description);
    profile.timestamp = profile.timestamp.touch();
    await this.saveProfileRepository.execute(profile);
    return profile;
  }
}
