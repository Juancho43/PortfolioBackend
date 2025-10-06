import { CreateTagRequest } from './CreateTagRequest';

export class EditTagRequest {
  constructor(
    public id: string,
    public data: CreateTagRequest,
  ) {}
}