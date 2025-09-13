export class CreateEducationRequest {
  constructor(
    public title: string,
    public description: string,
    public startDate: string,
    public endDate: string,
    public links: string[],
    public projects: string[],
    public tag: string[],
  ) {}
}
