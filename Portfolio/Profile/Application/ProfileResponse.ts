import { IResponse } from '../../Shared/Application/IResponse';
import { Profile } from '../Domain/Profile';

export class ProfileResponse implements IResponse<Profile> {
  generate(data: Profile): any {
    return {
      id: data.id,
      name: 'dsd',
      rol: data.rol,
      description: data.description,
      bio: data.bio,
      createdAt: data.timestamp.getCreatedAt(),
      updatedAt: data.timestamp.getUpdatedAt(),
    }
  }
}