import { CreateLinkRequest } from './CreateLinkRequest';

export class EditLinkRequest {
  constructor(
    public id: string,
    public data: CreateLinkRequest,
  ) {}
}
