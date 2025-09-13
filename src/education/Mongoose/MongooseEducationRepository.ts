import { EducationRepository } from '../../../Portfolio/Educations/Domain/EducationRepository';
import { Injectable } from '@nestjs/common';

import { Model } from 'mongoose';
import { InjectModel } from '@nestjs/mongoose';
import { EducationDocument } from './MongooseEducation';
import { Education } from 'Portfolio/Educations/Domain/Education';
import { EducationMapper } from './educationMapper';
import e from 'express';

@Injectable()
export class MongooseEducationRepository implements EducationRepository {
  constructor(
    @InjectModel('Educations') // <-- Inyectamos el modelo de Mongoose
    private readonly documentModel: Model<EducationDocument>,
  ) {}
async save(education: Education): Promise<void> {
  const educationDoc = EducationMapper.toPersistence(education);
  await new this.documentModel(educationDoc).save();
}
  async getAll(page: number, limit: number): Promise<Education[]> {
    const skip = (page - 1) * limit;

    const educations = await this.documentModel
      .find({ softdelete: false })
      .skip(skip)
      .limit(limit)
      .sort({ timestamp: -1 })
      .exec();

    return EducationMapper.toDomainEntities(educations);
  }
  getById(id: string): Education | null {
    throw new Error('Method not implemented.');
  }
  getBySlug(slug: string): Education | null {
    throw new Error('Method not implemented.');
  }
}