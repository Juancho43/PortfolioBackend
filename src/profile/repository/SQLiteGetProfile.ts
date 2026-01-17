import type { GetProfileRepository } from 'Portfolio/Profile/Domain/GetProfileRepository';
import { Profile } from 'Portfolio/Profile/Domain/Profile';
import { ProfileEntity } from '../profile.entity';
import { Injectable } from '@nestjs/common';
import { ProfileName } from '../../../Portfolio/Profile/Domain/ValueObjects/ProfileName';
import { ProfileDescription } from '../../../Portfolio/Profile/Domain/ValueObjects/ProfileDescription';
import { ProfileId } from '../../../Portfolio/Profile/Domain/ValueObjects/ProfileId';
import { ProfileRole } from '../../../Portfolio/Profile/Domain/ValueObjects/ProfileRol';
import { ProfileBio } from '../../../Portfolio/Profile/Domain/ValueObjects/ProfileBio';
import { Timestamp } from '../../../Portfolio/Shared/Domain/Timestamp';
import { SoftDelete } from '../../../Portfolio/Shared/Domain/SoftDelete';
import { EntityManager } from '@mikro-orm/core';

@Injectable()
export class SQLiteGetProfile implements GetProfileRepository {

  constructor(private readonly em: EntityManager) {}

  async getById(id: string): Promise<Profile | null> {
    // 1. Fetch from database using the ID
    const profile = await this.em.findOne(ProfileEntity, { id });
    if (!profile) {
      return null;
      // Or throw a specific DomainNotFoundError if your interface expects it
    }

    // 2. Return the profile (MikroORM entities usually satisfy the interface
    // if the property names match, otherwise map it manually)
    return Profile.create(
      ProfileId.create(profile.id),
      ProfileName.create(profile.name),
      ProfileRole.create(profile.role),
      ProfileBio.create(profile.bio),
      ProfileDescription.create(profile.description),
      Timestamp.fromDates(profile.createdAt, profile.updatedAt),
      SoftDelete.no(),
    );
  }
}
