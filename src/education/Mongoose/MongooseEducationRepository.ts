import { EducationRepository } from '../../../Portfolio/Educations/Domain/EducationRepository';
import { Injectable } from '@nestjs/common';

import { Education } from 'Portfolio/Educations/Domain/Education';
import { EducationTitle } from '../../../Portfolio/Educations/Domain/ValueObject/EducationTitle';
import { Timestamp } from '../../../Portfolio/Shared/Domain/Timestamp';
import { EducationId } from '../../../Portfolio/Educations/Domain/ValueObject/EducationId';
import { EducationDescription } from '../../../Portfolio/Educations/Domain/ValueObject/EducationDescription';
import { EducationPeriod } from '../../../Portfolio/Educations/Domain/ValueObject/EducationPeriod';
import { EducationSlug } from '../../../Portfolio/Educations/Domain/ValueObject/EducationSlug';
import { SoftDelete } from '../../../Portfolio/Shared/Domain/SoftDelete';
import { Link } from '../../../Portfolio/Links/Domain/Link';
import { LinkId } from '../../../Portfolio/Links/Domain/ValueObject/LinkId';
import { LinkTitle } from '../../../Portfolio/Links/Domain/ValueObject/LinkTitle';
import { LinkUrl } from '../../../Portfolio/Links/Domain/ValueObject/LinkUrl';
import { MongoClient, Db, Collection, ObjectId } from 'mongodb';

@Injectable()
export class MongooseEducationRepository implements EducationRepository {
  private db: Db;
  private collection: Collection;

  constructor() {
    // Inicializar conexión
    this.initConnection().then();
  }

  private async initConnection() {
    const client = new MongoClient(
      process.env.MONGODB_URI || 'mongodb://localhost:27017',
    );
    await client.connect();
    this.db = client.db(process.env.DB_NAME || 'portfolio');
    this.collection = this.db.collection('educations');
  }
  async save(education: Education): Promise<void> {
    const educationData = {
      title: education.title.value.getValue(),
      description: education.description.value.getValue(),
      slug: education.slug.value.getValue(),
      period: {
        start: education.peridod.startDate,
        end: education.peridod.endDate,
      },
      // Projects como array de ObjectIds (referencias)
      projects: education.projects?.map(p => new ObjectId(p.id.getValue())) || [],

      // Links como documentos embebidos
      links: education.links?.map(link => ({
        _id: new ObjectId(),
        title: link.title.value.getValue(),
        url: link.url.value,
      })) || [],

      // Tags como documentos embebidos
      tags: education.tags?.map(tag => ({
        title: tag.title.value.getValue(),
      })) || [],

      createdAt: education.timestamp.getCreatedAt(),
      updatedAt: new Date(),
      softdelete: education.softdelete.isSoftDeleted(),
    };

    // Si tiene ID, hacer update, sino insert
    const educationId = education.id.id.getValue();

    if (educationId && ObjectId.isValid(educationId)) {
      // Update
      await this.collection.updateOne(
        { _id: new ObjectId(educationId) },
        { $set: educationData }
      );
    } else {
      // Insert nuevo
      await this.collection.insertOne(educationData);
    }
  }
  async getAll(page: number, limit: number): Promise<Education[]> {
    const skip = (page - 1) * limit;

    const educationsData = await this.collection
      .find({ softdelete: false })
      .skip(skip)
      .limit(limit)
      .sort({ createdAt: -1 })
      .toArray();

    // Mapear a objetos de dominio
    return educationsData.map((data) => this.mapToDomain(data));
  }
  getById(id: string): Education | null {
    throw new Error('Method not implemented.');
  }
  getBySlug(slug: string): Education | null {
    throw new Error('Method not implemented.');
  }
  private mapToDomain(data: any): Education {
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
