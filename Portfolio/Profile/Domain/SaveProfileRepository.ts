import { Profile } from './Profile';

export interface SaveProfileRepository {
  execute(profile: Profile): Promise<void>;
}
