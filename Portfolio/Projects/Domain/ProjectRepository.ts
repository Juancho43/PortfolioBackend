import { Project } from './Project';
import { Paginated } from '../../Shared/Domain/Paginated';

export interface ProjectRepository {
  save(project: Project): void;
  getById(id: string): Promise<Project | null>;
  getAll(page: number, limit: number): Promise<Project[]>;
  getBySlug(slug: string): Promise<Project | null>;
  delete(id: string): void;
  getPinnedProjects(): Promise<Project[]>;
  getByTag(paginated: Paginated, tag: string): Promise<Project[]>;
}