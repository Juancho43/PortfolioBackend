import { Education } from '../../../Portfolio/Educations/Domain/Education';
import { EducationId } from '../../../Portfolio/Educations/Domain/ValueObject/EducationId';
import { EducationTitle } from '../../../Portfolio/Educations/Domain/ValueObject/EducationTitle';
import { EducationDescription } from '../../../Portfolio/Educations/Domain/ValueObject/EducationDescription';
import { EducationPeriod } from '../../../Portfolio/Educations/Domain/ValueObject/EducationPeriod';
import { EducationSlug } from '../../../Portfolio/Educations/Domain/ValueObject/EducationSlug';
import { Timestamp } from '../../../Portfolio/Shared/Domain/Timestamp';
import { SoftDelete } from '../../../Portfolio/Shared/Domain/SoftDelete';
import { EducationDocument } from './MongooseEducation';

export class EducationMapper {
  static toDomainEntities(educations: any[]): Education[] {
    return educations.map((doc) => {
      return Education.create(
        EducationId.create(doc.id),
        EducationTitle.create(doc.title),
        EducationDescription.create(doc.description),
        EducationPeriod.create(doc.period.startDate, doc.period.endDate),
        EducationSlug.create(doc.slug),
        Timestamp.fromDates(doc.timestamp.create, doc.timestamp.update),
        SoftDelete.no(),
      );
    });
  }

  static toPersistence(education: Education)  {
    return {
      _id: education.id.id.getValue(),
      title: education.title.value.getValue(),
      description: education.description.value.getValue(),
      period: {
        start: education.peridod.startDate,
        end: education.peridod.endDate,
      },
      slug: education.slug.value.getValue(),
      // projects, links, and tags should be mapped if available in your domain model
      projects: [], // Adjust mapping as needed
      links: [], // Adjust mapping as needed
      tags: [], // Adjust mapping as needed
      timestamp: education.timestamp.getCreatedAt(), // Assuming 'create' is the main timestamp
      softdelete: false, // Adjust if your domain model supports soft delete
    };
  }
}
