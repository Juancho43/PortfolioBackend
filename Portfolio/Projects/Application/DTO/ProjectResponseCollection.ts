import { IResponse } from '../../../Shared/Application/IResponse';
import { Project } from '../../Domain/Project';
import { ProjectResponse } from './ProjectResponse';

export class ProjectResponseCollection implements IResponse<Project[]> {
  generate(data: Project[]): any {
    if (!Array.isArray(data)) return [];
    return data.map((project) => {
      new ProjectResponse().generate(project);
    });
  }
}
