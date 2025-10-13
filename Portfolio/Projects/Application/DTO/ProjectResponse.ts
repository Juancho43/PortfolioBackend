import { IResponse } from '../../../Shared/Application/IResponse';
import { Project } from '../../Domain/Project';

export class ProjectResponse implements IResponse<Project> {
  generate(data: Project) {
    return {
      id: data.id.getValue(),
      title: data.title.getValue(),
      description: data.description.getValue(),
      slug: data.slug.value.getValue(),
      // links: new LinkResponseCollection().generate(data.links),
      // tags: new TagResponseCollection().generate(data.tags),
      createdAt: data.timestamp.getCreatedAt(),
      updatedAt: data.timestamp.getUpdatedAt(),
      deletedAt: data.softdelete.getDeletedAt(),
    };
  }
}