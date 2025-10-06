import { Timestamp } from '../../Shared/Domain/Timestamp';
import { SoftDelete } from '../../Shared/Domain/SoftDelete';
import { Project } from '../../Projects/Domain/Project';
import { Link } from '../../Links/Domain/Link';
import { Tag } from '../../Tags/Domain/Tag';
import { EducationId } from './ValueObject/EducationId';
import { EducationTitle } from './ValueObject/EducationTitle';
import { EducationSlug } from './ValueObject/EducationSlug';
import { EducationPeriod } from './ValueObject/EducationPeriod';
import { EducationDescription } from './ValueObject/EducationDescription';

export class Education {
  private _id: EducationId;
  private _title: EducationTitle;
  private _description: EducationDescription;
  private _peridod: EducationPeriod;
  private _slug: EducationSlug;
  private _projects: Project[];
  private _links: Link[];
  private _tags: Tag[];
  private _timestamp: Timestamp;
  private _softdelete: SoftDelete;

  private constructor(
    id: EducationId,
    title: EducationTitle,
    description: EducationDescription,
    peridod: EducationPeriod,
    slug: EducationSlug,

    timestamp: Timestamp,
    softdelete: SoftDelete,
  ) {
    this._id = id;
    this._title = title;
    this._description = description;
    this._peridod = peridod;
    this._slug = slug;

    this._timestamp = timestamp;
    this._softdelete = softdelete;
  }

  static create(
    id: EducationId,
    title: EducationTitle,
    description: EducationDescription,
    peridod: EducationPeriod,
    slug: EducationSlug,

    timestamp: Timestamp,
    softdelete: SoftDelete,
  ): Education {
    return new Education(
      id,
      title,
      description,
      peridod,
      slug,

      timestamp,
      softdelete,
    );
  }

  get id(): EducationId {
    return this._id;
  }

  set id(value: EducationId) {
    this._id = value;
  }

  get title(): EducationTitle {
    return this._title;
  }

  set title(value: EducationTitle) {
    this._title = value;
  }

  get description(): EducationDescription {
    return this._description;
  }

  set description(value: EducationDescription) {
    this._description = value;
  }

  get peridod(): EducationPeriod {
    return this._peridod;
  }

  set peridod(value: EducationPeriod) {
    this._peridod = value;
  }

  get slug(): EducationSlug {
    return this._slug;
  }

  set slug(value: EducationSlug) {
    this._slug = value;
  }

  get projects(): Project[] {
    return this._projects;
  }

  set projects(value: Project[]) {
    this._projects = value;
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
