import { ProfileEntity } from './profile.entity';
import { Profile } from '../../Portfolio/Profile/Domain/Profile';

export class ProfileMapper {
  static ToDomain(entity: ProfileEntity) {}

  static toEntity(profile: Profile): ProfileEntity {
    const e = new ProfileEntity();
    e.id = profile.id.profileId.getValue();
    e.name = profile.name.name.getValue();
    e.role = profile.rol.role.getValue();
    e.description = profile.description.description.getValue();
    e.bio = profile.bio.bio.getValue();

    // Timestamp -> Date

    e.createdAt = profile.timestamp.getCreatedAt();
    e.updatedAt = profile.timestamp.getUpdatedAt();

    // SoftDelete might expose boolean or an object with `isDeleted` / `value`

    e.deletedAt = profile.softDelete.isSoftDeleted();
      console.log(e)
    return e;
  }
}
