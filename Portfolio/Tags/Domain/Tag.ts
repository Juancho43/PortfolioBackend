import { Timestamp } from '../../Shared/Domain/Timestamp';
import { SoftDelete } from '../../Shared/Domain/SoftDelete';
import { TagId } from './ValueObject/TagId';
import { TagTitle } from './ValueObject/TagTitle';

export class Tag {
  private readonly _id: TagId;
  private _title: TagTitle;
  private _timestamp: Timestamp;
  private _softDelete: SoftDelete;

  private constructor(
    id: TagId,
    title: TagTitle,
    timestamp: Timestamp,
    softDelete: SoftDelete,
  ) {
    this._id = id;
    this._title = title;
    this._timestamp = timestamp;
    this._softDelete = softDelete;
  }

  static Create(
    id: TagId,
    title: TagTitle,
    timestamp: Timestamp,
    softDelete: SoftDelete,
  ) {
    return new Tag(id, title, timestamp, softDelete);
  }

  get id(): TagId {
    return this._id;
  }

  get title(): TagTitle {
    return this._title;
  }

  set title(value: TagTitle) {
    this._title = value;
  }

  get timestamp(): Timestamp {
    return this._timestamp;
  }

  set timestamp(value: Timestamp) {
    this._timestamp = value;
  }

  get softDelete(): SoftDelete {
    return this._softDelete;
  }

  set softDelete(value: SoftDelete) {
    this._softDelete = value;
  }
}
