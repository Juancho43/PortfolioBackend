import { IUseCase } from '../../Shared/Application/IUseCase';
import { Link } from '../Domain/Link';
import { GetLinkRepository } from '../Domain/GetLinkRepository';

export class GetLinkById implements IUseCase<string, Promise<Link>> {
  constructor(private readonly repository: GetLinkRepository) {}

  async execute(id: string): Promise<Link> {
    const link = await this.repository.getLinkById(id);
    if (!link) {
      throw new Error('Link not found');
    }
    return link;
  }
}
