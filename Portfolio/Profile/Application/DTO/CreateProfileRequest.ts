export class CreateProfileRequest {
  constructor(
    public readonly name: string,
    public readonly role: string,
    public readonly description: string,
    public readonly bio: string,
  ) {}
}
