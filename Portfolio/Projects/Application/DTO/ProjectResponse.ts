import { IResponse } from '../../../Shared/Application/IResponse';
import { ProjectId } from '../../Domain/ValueObject/ProjectId';
import { Project } from '../../Domain/Project';
import { LinkResponseCollection } from '../../../Links/Application/LinkResponseCollection';
import { TagResponseCollection } from '../../../Tags/Application/DTO/TagResponseCollection';

export class ProjectResponse implements IResponse<Project> {
  generate(data: Project): any {
    return {
      id: data.id.getValue(),
      title: data.title,
      slug: data.slug,
      links: new LinkResponseCollection().generate(data.links),
      tags: new TagResponseCollection().generate(data.tags),
      createdAt: data.timestamp.getCreatedAt(),
      updatedAt: data.timestamp.getUpdatedAt(),
      deletedAt: data.softdelete.getDeletedAt(),

    }
  }
}