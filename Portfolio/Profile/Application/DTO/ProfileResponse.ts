import { IResponse } from '../../../Shared/Application/IResponse';
import { Profile } from '../../Domain/Profile';

export class ProfileResponse implements IResponse<Profile> {
  generate(data: Profile): any {
    return {
      id: data.id.profileId.getValue(),
      name: data.name.name.getValue(),
      rol: data.rol.role.getValue(),
      description: data.description.description.getValue(),
      bio: data.bio.bio.getValue(),
      createdAt: data.timestamp.getCreatedAt(),
      updatedAt: data.timestamp.getUpdatedAt(),
    };
  }
}
