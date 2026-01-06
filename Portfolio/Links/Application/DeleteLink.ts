import { IUseCase } from '../../Shared/Application/IUseCase';
import { DeleteLinkRequest } from './DTO/DeleteLinkRequest';
import { GetLinkById } from './GetLinkById';
import { SaveLinkRepository } from '../Domain/SaveLinkRepository';

export class DeleteLink implements IUseCase<DeleteLinkRequest, void> {
  constructor(
    private readonly get: GetLinkById,
    private readonly repository: SaveLinkRepository,
  ) {}

  async execute(arg: DeleteLinkRequest): Promise<void> {
    const link = await this.get.execute(arg.id);
    link.softdelete = link.softdelete.delete();
    await this.repository.save(link);
  }
}
