import { UploadImageRequest } from '../../../Images/Application/DTO/UploadImageRequest';

export class UpdateUserImageRequest {
  constructor(
    public id: string,
    public image: UploadImageRequest,
  ) {}
}
