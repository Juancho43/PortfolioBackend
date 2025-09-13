import { Module } from '@nestjs/common';
import { MongooseModule } from '@nestjs/mongoose';
import { EducationSchema } from './Mongoose/MongooseEducation';
import { GetEducationBySlugController } from './controllers/get-education-by-slug-controller/get-education-by-slug-controller.controller';
import { EDUCATION_REPOSITORY_TOKEN } from './Mongoose/education.constansts';
import { MongooseEducationRepository } from './Mongoose/MongooseEducationRepository';
import { EducationService } from './education-service/education-service.service';
import { IdStrategiesModule } from '../id-strategies/id-strategies.module';
import { CreateEducationController } from './controllers/create-education/create-education.controller';
import { GetEducationController } from './controllers/get-education/get-education.controller';

@Module({
  imports: [
    MongooseModule.forFeature([
      { name: 'Educations', schema: EducationSchema },
    ]),
    IdStrategiesModule,
  ],
  controllers: [
    GetEducationBySlugController,
    CreateEducationController,
    GetEducationController,
  ],
  providers: [
    EducationService,
    {
      provide: EDUCATION_REPOSITORY_TOKEN, // <-- Tu "token" de inyección
      useClass: MongooseEducationRepository, // <-- Tu implementación
    },
  ],
})
export class EducationModule {}
