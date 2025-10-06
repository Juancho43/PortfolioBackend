import { CreateLinkRequest } from '../../../Links/Application/CreateLinkRequest';
import { CreateProjectRequest } from '../../../Projects/Application/DTO/CreateProjectRequest';
import { CreateTagRequest } from '../../../Tags/Application/DTO/CreateTagRequest';

export class CreateEducationRequest {
  constructor(
    public title: string,
    public description: string,
    public startDate: string,
    public endDate: string,
    public links: CreateLinkRequest[],
    public projects: CreateProjectRequest[],
    public tag: CreateTagRequest[],
  ) {}
}
