export class UploadFileRequest {
  constructor(
    public readonly name: string,
    public readonly size: number,
    public readonly type: string,
    public readonly buffer: Buffer,
  ) {}
}
