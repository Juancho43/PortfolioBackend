import { Education } from '../../../Portfolio/Educations/Domain/Education';
import { ObjectId } from 'mongodb';
import { EducationId } from '../../../Portfolio/Educations/Domain/ValueObject/EducationId';
import { EducationTitle } from '../../../Portfolio/Educations/Domain/ValueObject/EducationTitle';
import { EducationDescription } from '../../../Portfolio/Educations/Domain/ValueObject/EducationDescription';
import { EducationPeriod } from '../../../Portfolio/Educations/Domain/ValueObject/EducationPeriod';
import { EducationSlug } from '../../../Portfolio/Educations/Domain/ValueObject/EducationSlug';
import { Timestamp } from '../../../Portfolio/Shared/Domain/Timestamp';
import { SoftDelete } from '../../../Portfolio/Shared/Domain/SoftDelete';
import { Link } from '../../../Portfolio/Links/Domain/Link';
import { LinkId } from '../../../Portfolio/Links/Domain/ValueObject/LinkId';
import { LinkTitle } from '../../../Portfolio/Links/Domain/ValueObject/LinkTitle';
import { LinkUrl } from '../../../Portfolio/Links/Domain/ValueObject/LinkUrl';

export class EducationMapper {
  public static buildEducationData(education: Education) {
    return {
      id: education.id.id.getValue(),
      title: education.title.value.getValue(),
      description: education.description.value.getValue(),
      slug: education.slug.value.getValue(),
      period: {
        start: education.peridod.startDate,
        end: education.peridod.endDate,
      },
      projects:
        education.projects?.map((p) => new ObjectId(p.id.getValue())) || [],
      links:
        education.links?.map((link) => ({
          _id: new ObjectId(),
          title: link.title.value.getValue(),
          url: link.url.value,
        })) || [],
      tags:
        education.tags?.map((tag) => ({
          title: tag.title.value.getValue(),
        })) || [],
      createdAt: education.timestamp.getCreatedAt(),
      updatedAt: new Date(),
      softdelete: education.softdelete.isSoftDeleted(),
    };
  }
  public static mapToDomain(data: any): Education {
    const education = Education.create(
      EducationId.create(data._id.toString()),
      EducationTitle.create(data.title),
      EducationDescription.create(data.description),
      EducationPeriod.create(data.period.start, data.period.end),
      EducationSlug.create(data.slug),
      Timestamp.fromDates(data.createdAt, data.updatedAt),
      data.softdelete ? SoftDelete.yes() : SoftDelete.no(),
    );

    // Mapear links
    if (data.links && Array.isArray(data.links)) {
      education.links = data.links.map((linkData) =>
        Link.create(
          LinkId.create(linkData._id),
          LinkTitle.create(linkData.title),
          LinkUrl.create(linkData.url),
          Timestamp.now(),
          SoftDelete.no(),
        ),
      );
    }

    /* Mapear tags
      if (data.tags && Array.isArray(data.tags)) {
        education.tags = data.tags.map(tagData =>
          Tag.create(
            TagId.create(new ObjectId().toString()), // Generar ID si no tiene
            TagName.create(tagData.name),
            Timestamp.now(),
            SoftDelete.no(),
          )
        );
      }
*/
    return education;
  }
}
