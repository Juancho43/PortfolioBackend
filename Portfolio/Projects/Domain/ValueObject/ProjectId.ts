import { IdValueObject } from '../../../Shared/Domain/IdValueObject';

export class ProjectId {
  private readonly id: IdValueObject;

  private constructor(id: IdValueObject) {
    this.id = id;
  }

  public static create(id: string): ProjectId {
    return new ProjectId(IdValueObject.create(id));
  }

  public getValue(): string {
    return this.id.getValue();
  }

  public equals(other: ProjectId): boolean {
    return this.id.equals(other.id);
  }
}
