import { IUseCase } from '../../Shared/Application/IUseCase';
import { DeleteFile } from '../../Files/Application/DeleteFile';
import { SaveImageRepository } from '../Domain/SaveImageRepository';
import { DeleteImageRequest } from './DTO/DeleteImageRequest';
import { GetImageById } from './GetImageById';

export class DeleteImage
  implements IUseCase<DeleteImageRequest, Promise<void>>
{
  constructor(
    private readonly get: GetImageById,
    private readonly deleteFile: DeleteFile,
    private readonly repository: SaveImageRepository,
  ) {}

  async execute(imageId: DeleteImageRequest): Promise<void> {
    const image = await this.get.execute(imageId.id);
    await this.deleteFile.execute(image.file.id.fileId.getValue());
    image.softdeleted = image.softdeleted.delete();
    await this.repository.save(image);
  }
}
