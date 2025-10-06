import { TagRepository } from '../Domain/TagRepository';

export class GetTagById {
  private repository: TagRepository;
  constructor(repository: TagRepository) {
    this.repository = repository;
  }

  execute(id: string) {
    const tag = this.repository.getById(id);
    if (tag === null) {
      throw new Error('Tag not found');
    }
    return tag;
  }
}
