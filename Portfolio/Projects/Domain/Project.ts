import { ProjectSlug } from './ValueObject/ProjectSlug';
import { ProjectTitle } from './ValueObject/ProjectTitle';
import { ProjectId } from './ValueObject/ProjectId';
import { ProjectDescription } from './ValueObject/ProjectDescription';
import { Link } from '../../Links/Domain/Link';
import { Timestamp } from '../../Shared/Domain/Timestamp';
import { SoftDelete } from '../../Shared/Domain/SoftDelete';
import { Tag } from '../../Tags/Domain/Tag';

export class Project {
  private id: ProjectId;
  private title: ProjectTitle;
  private slug: ProjectSlug;
  private description: ProjectDescription;
  private links: Link[];
  private tags: Tag[];
  private timestamp: Timestamp;
  private softdelete: SoftDelete;

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
    this.id = id;
    this.title = title;
    this.slug = slug;
    this.description = description;
    this.links = links;
    this.tags = tags;
    this.timestamp = timestamp;
    this.softdelete = softdelete;
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
}
