import { Module } from '@nestjs/common';
import { IdStrategiesModule } from '../id-strategies/id-strategies.module';
import { GetProjectsController } from './controllers/get-projects/get-projects.controller';
import { GetProjectBySlugController } from './controllers/get-project-by-slug/get-project-by-slug.controller';
import { GetProjectsByTagController } from './controllers/get-projects-by-tag/get-projects-by-tag.controller';
import { GetPinnedProjectsController } from './controllers/get-pinned-projects/get-pinned-projects.controller';
import { EditProjectController } from './controllers/edit-project/edit-project.controller';
import { DeleteProjectController } from './controllers/delete-project/delete-project.controller';
import { CreateProjectController } from './controllers/create-project/create-project.controller';
import { PROJECT_REPOSITORY_TOKEN } from './Mongoose/projects.constansts';
import { ProjectsService } from './projects.service';
import { MongooseProjectRepository } from './Mongoose/MongooseProjectRepository';

@Module({
  imports: [IdStrategiesModule],
  controllers: [
    GetProjectsController,
    GetProjectBySlugController,
    GetProjectsByTagController,
    GetPinnedProjectsController,
    EditProjectController,
    DeleteProjectController,
    CreateProjectController,
  ],
  providers: [
    {
      provide: PROJECT_REPOSITORY_TOKEN, // <-- Tu "token" de inyección
      useClass: MongooseProjectRepository, // <-- Tu implementación
    },
    ProjectsService,
  ],
})
export class ProjectsModule {}
