import { IUseCase } from '../../Shared/Application/IUseCase';
import { EditLinkRequest } from './DTO/EditLinkRequest';
import { Link } from '../Domain/Link';
import { LinkTitle } from '../Domain/ValueObject/LinkTitle';
import { LinkUrl } from '../Domain/ValueObject/LinkUrl';
import { SaveLinkRepository } from '../Domain/SaveLinkRepository';
import { GetLinkById } from './GetLinkById';

export class EditLink implements IUseCase<EditLinkRequest, Promise<Link>> {
  constructor(
    private readonly get: GetLinkById,
    private readonly repository: SaveLinkRepository,
  ) {}

  async execute(request: EditLinkRequest): Promise<Link> {
    const link = await this.get.execute(request.id);
    link.title = LinkTitle.create(request.data.title);
    link.url = LinkUrl.create(request.data.url);
    link.timestamp = link.timestamp.touch();
    await this.repository.save(link);
    return link;
  }
}
