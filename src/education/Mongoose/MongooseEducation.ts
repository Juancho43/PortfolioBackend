import { Prop, Schema, SchemaFactory } from '@nestjs/mongoose';
import { Document, Types } from 'mongoose';
import { Project } from '../../../Portfolio/Projects/Domain/Project';
import { Link } from '../../../Portfolio/Links/Domain/Link';
import { Tag } from '../../../Portfolio/Tags/Domain/Tag';

@Schema()
export class MongooseEducation {
  @Prop({ required: true })
  _id: string;

  @Prop({ required: true })
  title: string;

  @Prop({ required: true })
  description: string;

  @Prop({
    type: {
      start: { type: Date, required: true },
      end: { type: Date, required: true },
    },
  })
  period: {
    start: Date;
    end: Date;
  };

  @Prop({ required: true })
  slug: string;

  @Prop({ type: [{ type: Types.ObjectId, ref: 'Project' }] })
  projects: Project[];

  @Prop([
    {
      url: { type: String, required: true },
      text: { type: String, required: true },
    },
  ])
  links: Link[];

  @Prop([
    {
      name: { type: String, required: true },
    },
  ])
  tags: Tag[];

  @Prop({
    type: {
      createdAt: { type: Date, required: true, default: Date.now },
      updatedAt: { type: Date, required: true, default: Date.now },
    },
    required: true,
  })
  timestamp: {
    createdAt: Date;
    updatedAt: Date;
  };

  @Prop({ required: true, default: false })
  softdelete: boolean;
}

export const EducationSchema = SchemaFactory.createForClass(MongooseEducation);
export type EducationDocument = MongooseEducation & Document;
export const EDUCATION_MODEL = 'Education';
