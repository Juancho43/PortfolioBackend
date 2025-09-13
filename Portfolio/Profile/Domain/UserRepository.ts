import { Profile } from './Profile';

export interface UserRepository {
  save(profile: Profile): void;
}
