import { Project } from './Project';

export interface ProjectRepository {
  save(project: Project): void;
  getById(id: string): Project | null;
}