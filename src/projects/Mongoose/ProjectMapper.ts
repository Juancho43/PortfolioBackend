import { Project } from '../../../Portfolio/Projects/Domain/Project';
import { ProjectTitle } from '../../../Portfolio/Projects/Domain/ValueObject/ProjectTitle';
import { ProjectId } from '../../../Portfolio/Projects/Domain/ValueObject/ProjectId';
import { ProjectDescription } from '../../../Portfolio/Projects/Domain/ValueObject/ProjectDescription';
import { ProjectSlug } from '../../../Portfolio/Projects/Domain/ValueObject/ProjectSlug';
import { Timestamp } from '../../../Portfolio/Shared/Domain/Timestamp';
import { SoftDelete } from '../../../Portfolio/Shared/Domain/SoftDelete';
import { Pinned } from '../../../Portfolio/Shared/Domain/Pinned';
import { ObjectId } from 'mongodb';

export class ProjectMapper {
  public static mapToDomain(data: any): Project {

    return Project.Create(
      ProjectId.create(data._id),
      ProjectTitle.create(data.title),
      ProjectSlug.create(data.slug),
      ProjectDescription.create(data.description),
      Pinned.create(data.pinned),
      Timestamp.fromDates(data.createdAt, data.updatedAt),
      data.softdelete ? SoftDelete.yes() : SoftDelete.no(),
    );
  }
  public static buildProjectData(data: Project) {
    return {
      _id: new ObjectId(),
      title: data.title.getValue(),
      description: data.description.getValue(),
      slug: data.slug.value.getValue(),
      pinned: data.isPinned.getValue(),
      links:
        data.links?.map((link) => ({
          _id: new ObjectId(),
          title: link.title.value.getValue(),
          url: link.url.value,
        })) || [],
      tags:
        data.tags?.map((tag) => ({
          title: tag.title.value.getValue(),
        })) || [],
      createdAt: data.timestamp.getCreatedAt(),
      updatedAt: data.timestamp.getUpdatedAt(),
      softdelete: data.softdelete.isSoftDeleted(),
    };
  }
}
