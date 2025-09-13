import { Tag } from './Tag';

export interface TagRepository {
  save(tag: Tag): void;
  getById(id: string): Tag | null;
}
