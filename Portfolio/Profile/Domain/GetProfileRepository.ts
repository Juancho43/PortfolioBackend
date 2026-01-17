import { Profile } from './Profile';

export interface GetProfileRepository {
  getById(id: string): Promise<Profile | null>;
}
