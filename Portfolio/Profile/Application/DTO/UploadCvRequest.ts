import { UploadFileRequest } from '../../../Files/Application/DTO/UploadFileRequest';

export class UploadCvRequest {
  constructor(
    public readonly profileId: string,
    public readonly title: string,
    public readonly alt: string,
    public readonly file: UploadFileRequest,
  ) {}
}
