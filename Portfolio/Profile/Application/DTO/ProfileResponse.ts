import { IResponse } from '../../../Shared/Application/IResponse';
import { Profile } from '../../Domain/Profile';

export class ProfileResponse implements IResponse<Profile> {
  generate(data: Profile): any {
    return {
      id: data.id.profileId,
      name: data.name.name,
      rol: data.rol.role,
      description: data.description.description,
      bio: data.bio.bio,
      createdAt: data.timestamp.getCreatedAt(),
      updatedAt: data.timestamp.getUpdatedAt(),
    };
  }
}
