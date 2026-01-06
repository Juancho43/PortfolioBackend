import { UploadImageRequest } from '../../../Images/Application/DTO/UploadImageRequest';

export class UploadPhotoRequest {
  constructor(
    public readonly profileId: string,
    public readonly image: UploadImageRequest,
  ) {}
}
