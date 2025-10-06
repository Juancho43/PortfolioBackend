import { LinkId } from './ValueObject/LinkId';
import { LinkTitle } from './ValueObject/LinkTitle';
import { LinkUrl } from './ValueObject/LinkUrl';
import { Timestamp } from '../../Shared/Domain/Timestamp';
import { SoftDelete } from '../../Shared/Domain/SoftDelete';
import { timestamp } from 'rxjs';

export class Link {
  private readonly _id: LinkId;
  private _title: LinkTitle;
  private _url: LinkUrl;
  private _timestamp: Timestamp;
  private _softdelete: SoftDelete;

  private constructor(
    id: LinkId,
    title: LinkTitle,
    url: LinkUrl,
    timestamp: Timestamp,
    softdelete: SoftDelete,
  ) {
    this._id = id;
    this._title = title;
    this._url = url;
    this._timestamp = timestamp;
    this._softdelete = softdelete;
  }
  static create(
    id: LinkId,
    title: LinkTitle,
    url: LinkUrl,
    timestamp: Timestamp,
    softdelete: SoftDelete,
  ) {
    return new Link(id, title, url, timestamp, softdelete);
  }

  get id(): LinkId {
    return this._id;
  }

  get title(): LinkTitle {
    return this._title;
  }

  set title(value: LinkTitle) {
    this._title = value;
  }

  get url(): LinkUrl {
    return this._url;
  }

  set url(value: LinkUrl) {
    this._url = value;
  }

  get timestamp(): Timestamp {
    return this._timestamp;
  }

  set timestamp(value: Timestamp) {
    this._timestamp = value;
  }

  get softdelete(): SoftDelete {
    return this._softdelete;
  }

  set softdelete(value: SoftDelete) {
    this._softdelete = value;
  }
}
