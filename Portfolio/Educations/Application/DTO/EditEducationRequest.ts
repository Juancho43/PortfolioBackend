import { CreateEducationRequest } from './CreateEducationRequest';

export class EditEducationRequest {
  constructor(
    public educationId: string,
    public data: CreateEducationRequest,
  ) {}
}
