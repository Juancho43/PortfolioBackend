import { IUseCase } from '../../Shared/Application/IUseCase';
import { CreateLinkRequest } from './DTO/CreateLinkRequest';
import { Link } from '../Domain/Link';
import { SaveLinkRepository } from '../Domain/SaveLinkRepository';
import { randomUUID } from 'node:crypto';
import { LinkId } from '../Domain/ValueObject/LinkId';
import { LinkUrl } from '../Domain/ValueObject/LinkUrl';
import { LinkTitle } from '../Domain/ValueObject/LinkTitle';
import { Timestamp } from '../../Shared/Domain/Timestamp';
import { SoftDelete } from '../../Shared/Domain/SoftDelete';

export class CreateLink implements IUseCase<CreateLinkRequest, Promise<Link>> {
  constructor(private readonly repository: SaveLinkRepository) {}

  async execute(request: CreateLinkRequest): Promise<Link> {
    const link = Link.create(
      LinkId.create(randomUUID().toString()),
      LinkTitle.create(request.title),
      LinkUrl.create(request.url),
      Timestamp.now(),
      SoftDelete.no(),
    );
    await this.repository.save(link);

    return link;
  }
}
