import { ProjectSlug } from './ValueObject/ProjectSlug';
import { ProjectTitle } from './ValueObject/ProjectTitle';
import { ProjectId } from './ValueObject/ProjectId';
import { ProjectDescription } from './ValueObject/ProjectDescription';
import { Link } from '../../Links/Domain/Link';
import { Timestamp } from '../../Shared/Domain/Timestamp';
import { SoftDelete } from '../../Shared/Domain/SoftDelete';
import { Tag } from '../../Tags/Domain/Tag';


export class Project {
  private _id: ProjectId;
  private _title: ProjectTitle;
  private _slug: ProjectSlug;
  private _description: ProjectDescription;
  private _links: Link[];
  private _tags: Tag[];
  private _timestamp: Timestamp;
  private _softdelete: SoftDelete;

  private constructor(
    id: ProjectId,
    title: ProjectTitle,
    slug: ProjectSlug,
    description: ProjectDescription,
    links: Link[],
    tags: Tag[],
    timestamp: Timestamp,
    softdelete: SoftDelete,
  ) {
    this._id = id;
    this._title = title;
    this._slug = slug;
    this._description = description;
    this._links = links;
    this._tags = tags;
    this._timestamp = timestamp;
    this._softdelete = softdelete;
  }

  static Create(
    id: ProjectId,
    title: ProjectTitle,
    slug: ProjectSlug,
    description: ProjectDescription,
    links: Link[],
    tags: Tag[],
    timestamp: Timestamp,
    softdelete: SoftDelete,
  ): Project {
    return new Project(
      id,
      title,
      slug,
      description,
      links,
      tags,
      timestamp,
      softdelete,
    );
  }

  get id(): ProjectId {
    return this._id;
  }

  set id(value: ProjectId) {
    this._id = value;
  }

  get title(): ProjectTitle {
    return this._title;
  }

  set title(value: ProjectTitle) {
    this._title = value;
  }

  get slug(): ProjectSlug {
    return this._slug;
  }

  set slug(value: ProjectSlug) {
    this._slug = value;
  }

  get description(): ProjectDescription {
    return this._description;
  }

  set description(value: ProjectDescription) {
    this._description = value;
  }

  get links(): Link[] {
    return this._links;
  }

  set links(value: Link[]) {
    this._links = value;
  }

  get tags(): Tag[] {
    return this._tags;
  }

  set tags(value: Tag[]) {
    this._tags = value;
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
