import { Injectable } from '@nestjs/common';
import { UpdateUserImage } from '../../../../Portfolio/User/Application/UpdateUserImage';
import { UpdateUserImageRequest } from '../../../../Portfolio/User/Application/DTO/UpdateUserImageRequest';
import { UploadImage } from '../../../../Portfolio/Images/Application/UploadImage';
@Injectable()
export class UpdateUserImageService {
  constructor() {
  }

}
