import { StringValueObject } from '../../../Shared/Domain/StringValueObject';

export class ProjectDescription {
  private value: StringValueObject;

  private constructor(value: StringValueObject) {
    this.value = value;
  }

  static create(value: string) {
    return new ProjectDescription(StringValueObject.create(value));
  }
}
