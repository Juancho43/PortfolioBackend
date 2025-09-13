import { Module } from '@nestjs/common';
import { AppController } from './app.controller';
import { AppService } from './app.service';
import { UsersModule } from './users/users.module';
import { EducationModule } from './education/education.module';
import { ProjectsModule } from './projects/projects.module';
import { WorksModule } from './works/works.module';
import { ProfileModule } from './profile/profile.module';
import { MongooseModule } from '@nestjs/mongoose';
import { CreateEducationController } from './education/controllers/create-education/create-education.controller';
import { IdStrategiesModule } from './id-strategies/id-strategies.module';
import { GetProfileController } from './profile/get-profile/get-profile.controller';

@Module({
  imports: [
    MongooseModule.forRoot('mongodb://localhost:27017/portfolio'),
    UsersModule,
    EducationModule,
    ProjectsModule,
    WorksModule,
    ProfileModule,
    IdStrategiesModule,
  ],
  controllers: [AppController, GetProfileController ],
  providers: [AppService],
})
export class AppModule {}
