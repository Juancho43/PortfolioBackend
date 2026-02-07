import { Profile } from 'Portfolio/Profile/Domain/Profile';
import { SaveProfileRepository } from 'Portfolio/Profile/Domain/SaveProfileRepository';
import { Injectable } from '@nestjs/common';
import { EntityManager } from '@mikro-orm/core';
import { ProfileMapper } from '../ProfileMapper';
@Injectable()
export class SQLiteSaveProfile implements SaveProfileRepository {
  constructor(private readonly em: EntityManager) {}
   execute(profile: Profile): Promise<void> {
    console.log('=== DEBUG SAVE PROFILE ===');
    const entity = ProfileMapper.toEntity(profile);
    this.em.persist(entity);
     this.em.flush();
     return Promise.resolve();
  }
}
