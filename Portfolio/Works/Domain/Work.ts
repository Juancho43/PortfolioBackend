import { Project } from '../../Projects/Domain/Project';
import { WorkDescription } from './ValueObject/WorkDescription';
import { WorkId } from './ValueObject/WorkId';
import { WorkPosition } from './ValueObject/WorkPosition';
import { WorkCompany } from './ValueObject/WorkCompany';

export class Work {
  private readonly id: WorkId;
  private position: WorkPosition;
  private company: WorkCompany;
  private description: WorkDescription;
  private projects: Project[];
}