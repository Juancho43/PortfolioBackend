import { IUseCase } from '../../Shared/Application/IUseCase';
import { UploadFile } from '../../Files/Application/UploadFile';
import { SaveImageRepository } from '../Domain/SaveImageRepository';
import { UploadImageRequest } from './DTO/UploadImageRequest';
import { Image } from '../Domain/Image';
import { randomUUID } from 'node:crypto';
import { ImageHeight } from '../Domain/ValueObject/ImageHeight';
import { ImageWidth } from '../Domain/ValueObject/ImageWidth';
import { ImageId } from '../Domain/ValueObject/ImageId';
import { Timestamp } from '../../Shared/Domain/Timestamp';
import { SoftDelete } from '../../Shared/Domain/SoftDelete';

export class UploadImage
  implements IUseCase<UploadImageRequest, Promise<Image>>
{
  constructor(
    private readonly uploadFile: UploadFile,
    private readonly repository: SaveImageRepository,
  ) {}

  async execute(request: UploadImageRequest): Promise<Image> {
    const file = await this.uploadFile.execute(request.file);
    const image = Image.create(
      ImageId.create(randomUUID().toString()),
      file,
      ImageWidth.create(request.width),
      ImageHeight.create(request.height),
      Timestamp.now(),
      SoftDelete.no(),
    );
    await this.repository.save(image);
    return image;
  }
}
