import { Education } from '../../Domain/Education';
import { IResponse } from '../../../Shared/Application/IResponse';
import { TagResponseCollection } from '../../../Tags/Application/DTO/TagResponseCollection';
import { LinkResponseCollection } from '../../../Links/Application/LinkResponseCollection';
import { ProjectResponseCollection } from '../../../Projects/Application/DTO/ProjectResponseCollection';

export class EducationResponse implements IResponse<Education> {
  generate(education: Education): any {
    return {
      id: education.id.id.getValue(),
      title: education.title.value.getValue(),
      slug: education.slug.value.getValue(),
      description: education.description.value.getValue(),
      startDate: education.peridod.startDate,
      endDate: education.peridod.endDate,

      projects: new ProjectResponseCollection().generate(education.projects),
      links: new LinkResponseCollection().generate(
        education.links?.filter((l) => l != null),
      ),
      tags: new TagResponseCollection().generate(education.tags),
      createdAt: education.timestamp.getCreatedAt(),
      updatedAt: education.timestamp.getUpdatedAt(),
      deletedAt: education.softdelete.getDeletedAt(),
    };
  }
}
