import { Module } from '@nestjs/common';
import { AppController } from './app.controller';
import { AppService } from './app.service';
import { UsersModule } from './users/users.module';
import { EducationModule } from './education/education.module';
import { ProjectsModule } from './projects/projects.module';
import { WorksModule } from './works/works.module';
import { ProfileModule } from './profile/profile.module';
import { IdStrategiesModule } from './id-strategies/id-strategies.module';

@Module({
  imports: [
    UsersModule,
    EducationModule,
    ProjectsModule,
    WorksModule,
    ProfileModule,
    IdStrategiesModule,
  ],
  controllers: [AppController,],
  providers: [AppService],
})
export class AppModule { }
