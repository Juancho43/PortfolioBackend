import { IUseCase } from '../../Shared/Application/IUseCase';
import { GetProfileById } from './GetProfileById';
import { SaveProfileRepository } from '../Domain/SaveProfileRepository';
import { UploadImage } from '../../Images/Application/UploadImage';
import { UploadPhotoRequest } from './DTO/UploadPhotoRequest';
import { Image } from '../../Images/Domain/Image';

export class UploadPhoto
  implements IUseCase<UploadPhotoRequest, Promise<Image>>
{
  constructor(
    private readonly get: GetProfileById,
    private readonly uploadFile: UploadImage,
    private readonly repository: SaveProfileRepository,
  ) {}

  async execute(arg: UploadPhotoRequest): Promise<Image> {
    const profile = await this.get.execute(arg.profileId);
    profile.photo = await this.uploadFile.execute(arg.image);
    await this.repository.execute(profile);
    return profile.photo;
  }
}
