import { Project } from 'Portfolio/Projects/Domain/Project';
import { Paginated } from 'Portfolio/Shared/Domain/Paginated';
import { ProjectRepository } from '../../../Portfolio/Projects/Domain/ProjectRepository';

export class MongooseProjectRepository implements ProjectRepository {
  save(project: Project): void {
    throw new Error('Method not implemented.');
  }
  getById(id: string): Promise<Project | null> {
    throw new Error('Method not implemented.');
  }
  getAll(page: number, limit: number): Promise<Project[]> {
    throw new Error('Method not implemented.');
  }
  getBySlug(slug: string): Promise<Project | null> {
    throw new Error('Method not implemented.');
  }
  delete(id: string): void {
    throw new Error('Method not implemented.');
  }
  getPinnedProjects(): Promise<Project[]> {
    throw new Error('Method not implemented.');
  }
  getByTag(paginated: Paginated, tag: string): Promise<Project[]> {
    throw new Error('Method not implemented.');
  }
}