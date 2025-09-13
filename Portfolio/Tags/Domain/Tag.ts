import { Timestamp } from '../../Shared/Domain/Timestamp';
import { SoftDelete } from '../../Shared/Domain/SoftDelete';
import { TagId } from './ValueObject/TagId';
import { TagTitle } from './ValueObject/TagTitle';

export class Tag {
  private id: TagId;
  private title: TagTitle;
  private timestamp: Timestamp;
  private softDelete: SoftDelete;

  private constructor(
    id: TagId,
    title: TagTitle,
    timestamp: Timestamp,
    softDelete: SoftDelete,
  ) {
    this.id = id;
    this.title = title;
    this.timestamp = timestamp;
    this.softDelete = softDelete;
  }

  static Create(
    id: TagId,
    title: TagTitle,
    timestamp: Timestamp,
    softDelete: SoftDelete,
  ) {
    return new Tag(id, title, timestamp, softDelete);
  }
}
