import { EducationRepository } from '../../../Portfolio/Educations/Domain/EducationRepository';
import { Injectable } from '@nestjs/common';

import { Education } from 'Portfolio/Educations/Domain/Education';

import { Collection, Db, MongoClient, ObjectId } from 'mongodb';
import { EducationMapper } from './education-mapper';

@Injectable()
export class MongooseEducationRepository implements EducationRepository {
  private db: Db;
  private collection: Collection;

  constructor() {
    // Inicializar conexión
    //this.initConnection().then();
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
    const educationData = EducationMapper.buildEducationData(education);

    // Si tiene ID, hacer update, sino insert
    const educationId = education.id.id.getValue();

    if (educationId && ObjectId.isValid(educationId)) {
      // Update
      await this.collection.updateOne(
        { _id: new ObjectId(educationId) },
        { $set: educationData },
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
    return educationsData.map((data) => EducationMapper.mapToDomain(data));
  }

  async getById(id: string): Promise<Education | null> {
    if (!ObjectId.isValid(id)) return null;
    const data = await this.collection.findOne({
      _id: new ObjectId(id),
      softdelete: false,
    });
    return data ? EducationMapper.mapToDomain(data) : null;
  }

  async getBySlug(slug: string): Promise<Education | null> {
    const data = await this.collection.findOne({ slug, softdelete: false });
    return data ? EducationMapper.mapToDomain(data) : null;
  }

  async delete(id: string): Promise<boolean> {
    if (!ObjectId.isValid(id)) return false;
    const result = await this.collection.updateOne(
      { _id: new ObjectId(id) },
      { $set: { softdelete: true } },
    );
    return result.modifiedCount > 0;
  }
}
