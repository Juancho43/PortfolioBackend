import { IdValueObject } from '../../../Shared/Domain/IdValueObject';

export class UserId {
  private readonly id: IdValueObject;

  private constructor(id: IdValueObject) {
    this.id = id;
  }

  public static create(id: string): UserId {
    return new UserId(IdValueObject.create(id));
  }

  public getValue(): string {
    return this.id.getValue();
  }

  public equals(other: UserId): boolean {
    return this.id.equals(other.id);
  }
}