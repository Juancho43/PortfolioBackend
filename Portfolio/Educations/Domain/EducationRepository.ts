import { Education } from './Education';

export interface EducationRepository {
  save(education: Education): Promise<void>;
  getAll(page: number, limit: number): Promise<Education[]>;
  getById(id: string): Education | null;
  getBySlug(slug: string): Education | null;
}