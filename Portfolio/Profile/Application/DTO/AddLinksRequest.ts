import { CreateLinkRequest } from '../../../Links/Application/DTO/CreateLinkRequest';

export class AddLinksRequest {
  constructor(
    public readonly profileId: string,
    public readonly links: CreateLinkRequest[],
  ) {}
}
