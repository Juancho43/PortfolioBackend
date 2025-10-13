import { StringValueObject } from '../../../Shared/Domain/StringValueObject';

export class ProjectTitle {
  private value: StringValueObject;

  constructor(value: StringValueObject) {
    this.value = value;
  }
  public static create(value: string) {
    return new ProjectTitle(StringValueObject.create(value));
  }
   getValue(): string {
    return this.value.getValue();
  }
}
