import { SoftDelete } from '../../Shared/Domain/SoftDelete';
import { Timestamp } from '../../Shared/Domain/Timestamp';
import { Profile } from '../Domain/Profile';
import { SaveProfileRepository } from '../Domain/SaveProfileRepository';
import { ProfileBio } from '../Domain/ValueObjects/ProfileBio';
import { ProfileDescription } from '../Domain/ValueObjects/ProfileDescription';
import { ProfileId } from '../Domain/ValueObjects/ProfileId';
import { ProfileName } from '../Domain/ValueObjects/ProfileName';
import { ProfileRole } from '../Domain/ValueObjects/ProfileRol';
import { CreateProfileRequest } from './DTO/CreateProfileRequest';
import { IUseCase } from '../../Shared/Application/IUseCase';
import { randomUUID } from 'node:crypto';

export class CreateProfile
  implements IUseCase<CreateProfileRequest, Promise<Profile>>
{
  constructor(private readonly saveProfileRepository: SaveProfileRepository) {}

  async execute(arg: CreateProfileRequest): Promise<Profile> {
    const profile = Profile.create(
      ProfileId.create(randomUUID().toString()),
      ProfileName.create(arg.name),
      ProfileRole.create(arg.role),
      ProfileBio.create(arg.bio),
      ProfileDescription.create(arg.description),
      Timestamp.now(),
      SoftDelete.no(),
    );
    await this.saveProfileRepository.execute(profile);
    return profile;
  }
}
