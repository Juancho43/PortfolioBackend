import { Profile } from 'Portfolio/Profile/Domain/Profile';
import { SaveProfileRepository } from 'Portfolio/Profile/Domain/SaveProfileRepository';

export class SQLiteSaveProfile implements SaveProfileRepository {
  execute(profile: Profile): Promise<void> {
    throw new Error('Method not implemented.');
  }
}
