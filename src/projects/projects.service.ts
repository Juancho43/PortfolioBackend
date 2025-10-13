import { Inject, Injectable } from '@nestjs/common';
import { CreateProject } from '../../Portfolio/Projects/Application/CreateProject';
import { GetProjectBySlug } from '../../Portfolio/Projects/Application/GetProjectBySlug';
import { GetAllProjects } from '../../Portfolio/Projects/Application/GetAllProjects';
import { EditProject } from '../../Portfolio/Projects/Application/EditProject';
import { GetProjectById } from '../../Portfolio/Projects/Application/GetProjectById';
import { DeleteProject } from '../../Portfolio/Projects/Application/DeleteProject';
import { PROJECT_REPOSITORY_TOKEN } from './Mongoose/projects.constansts';
import type { ProjectRepository } from '../../Portfolio/Projects/Domain/ProjectRepository';
import type { IdGeneratorStrategy } from '../../Portfolio/Shared/Domain/IdGeneratorStrategy';
import { GetPinnedProjects } from '../../Portfolio/Projects/Application/GetPinnedProjects';
import { GetProjectsByTag } from '../../Portfolio/Projects/Application/GetProjectsByTag';
import { CreateProjectRequest } from '../../Portfolio/Projects/Application/DTO/CreateProjectRequest';
import { EditProjectRequest } from '../../Portfolio/Projects/Application/DTO/EditProjectRequest';
import { DeleteProjectRequest } from '../../Portfolio/Projects/Application/DTO/DeleteProjectRequest';
import { ID_GENERATOR_TOKEN } from '../id-strategies/token';

@Injectable()
export class ProjectsService {
  private getBySlug: GetProjectBySlug;
  private create: CreateProject;
  private getAll: GetAllProjects;
  private getPinned: GetPinnedProjects;
  private getByTag: GetProjectsByTag;
  private readonly getById: GetProjectById;
  private edit: EditProject;
  private delete: DeleteProject;
  constructor(
    @Inject(PROJECT_REPOSITORY_TOKEN)
    private readonly repository: ProjectRepository,
    @Inject(ID_GENERATOR_TOKEN)
    private readonly generator: IdGeneratorStrategy,
  ) {
    this.create = new CreateProject(this.repository, this.generator);
    this.getBySlug = new GetProjectBySlug(this.repository);
    this.getAll = new GetAllProjects(this.repository);
    this.getById = new GetProjectById(this.repository);
    this.edit = new EditProject(this.repository, this.getById);
    this.delete = new DeleteProject(this.repository, this.getById);
  }

  execute_getAll(page: string, limit: string) {
    return this.getAll.execute({
      page: parseInt(page),
      limit: parseInt(limit),
    });
  }
  async execute_getBySlug(slug: string) {
    return await this.getBySlug.execute(slug);
  }
  execute_create(data: CreateProjectRequest) {
    return this.create.execute(data);
  }
  async execute_edit(data: EditProjectRequest) {
    return await this.edit.execute(data);
  }
  async execute_delete(request: DeleteProjectRequest) {
    return await this.delete.execute(request);
  }
  async execute_getPinnedProjects() {
    return await this.getPinned.execute();
  }
  async execute_getByTag(page: string, limit: string, tag: string) {
    return await this.getByTag.execute({
      paginated: { page: parseInt(page), limit: parseInt(limit) },
      tag,
    });
  }
}
