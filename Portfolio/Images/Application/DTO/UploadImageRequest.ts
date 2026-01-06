import { UploadFileRequest } from '../../../Files/Application/DTO/UploadFileRequest';

export class UploadImageRequest {
  constructor(
    public readonly width: number,
    public readonly height: number,
    public readonly file: UploadFileRequest,
  ) {}
}
