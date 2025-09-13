import { IdValueObject } from '../../../Shared/Domain/IdValueObject';

export class TagId {
  private readonly id: IdValueObject;

  private constructor(id: IdValueObject) {
    this.id = id;
  }

  public static create(id: string): TagId {
    return new TagId(IdValueObject.create(id));
  }

  public getValue(): string {
    return this.id.getValue();
  }

  public equals(other: TagId): boolean {
    return this.id.equals(other.id);
  }
}