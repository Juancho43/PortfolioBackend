import { IUseCase } from '../../Shared/Application/IUseCase';
import { AddLinksRequest } from './DTO/AddLinksRequest';
import { Profile } from '../Domain/Profile';
import { GetProfileById } from './GetProfileById';
import { CreateLink } from '../../Links/Application/CreateLink';
import { SaveProfileRepository } from '../Domain/SaveProfileRepository';

export class AddProfileLinks
  implements IUseCase<AddLinksRequest, Promise<Profile>>
{
  constructor(
    private readonly get: GetProfileById,
    private readonly createLink: CreateLink,
    private readonly repository: SaveProfileRepository,
  ) {}

  async execute(arg: AddLinksRequest): Promise<Profile> {
    const profile = await this.get.execute(arg.profileId);
    for (const request of arg.links) {
      const link = await this.createLink.execute(request);
      profile.links.push(link);
    }
    await this.repository.execute(profile);
    return profile;
  }
}
