import { User } from './User';

export interface UserRepository {
  getById(id: string): User | null;
  save(user: User): void;
  delete(id: string): void;
}
