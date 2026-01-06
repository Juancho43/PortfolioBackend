import { UploadImage } from '../../Images/Application/UploadImage';
import { IUseCase } from '../../Shared/Application/IUseCase';
import { UpdateUserImageRequest } from './DTO/UpdateUserImageRequest';
import { Image } from '../../Images/Domain/Image';

export class UpdateUserImage
  implements IUseCase<UpdateUserImageRequest, Promise<Image>>
{
  constructor(private UploadImage: UploadImage) {}

  async execute(request: UpdateUserImageRequest): Promise<Image> {
    return await this.UploadImage.execute(request.image);
  }
}
