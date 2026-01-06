export class CreateProfileDTO {
  constructor(
    public name: string,
    public role: string,
    public description: string,
    public bio: string,
  ) {}
}
