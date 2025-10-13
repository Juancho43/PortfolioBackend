import { CreateProjectRequest } from './CreateProjectRequest';

export class EditProjectRequest {
  constructor(
    public projectId: string,
    public data: CreateProjectRequest,
  ) {}
}
