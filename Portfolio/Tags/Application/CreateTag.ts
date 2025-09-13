import { TagRepository } from '../Domain/TagRepository';
import { IdGeneratorStrategy } from '../../Shared/Domain/IdGeneratorStrategy';
import { Tag } from '../Domain/Tag';
import { TagId } from '../Domain/ValueObject/TagId';
import { TagTitle } from '../Domain/ValueObject/TagTitle';
import { Timestamp } from '../../Shared/Domain/Timestamp';
import { SoftDelete } from '../../Shared/Domain/SoftDelete';

export class CreateTag {
  private repository: TagRepository;
  private idGenerator: IdGeneratorStrategy;
  constructor(repository: TagRepository, idStrategy: IdGeneratorStrategy) {
    this.idGenerator = idStrategy;
    this.repository = repository;
  }

  execute(title: string) {
    const tag = Tag.Create(
      TagId.create(this.idGenerator.generate()),
      TagTitle.create(title),
      Timestamp.now(),
      SoftDelete.no(),
    );
    this.repository.save(tag);
    return tag;
  }
}
