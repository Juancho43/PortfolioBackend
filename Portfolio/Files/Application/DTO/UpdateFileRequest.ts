export class UpdateFileRequest {
  constructor(
    public readonly id: string,
    public readonly title: string,
    public readonly alt: string,
  ) {}
}
