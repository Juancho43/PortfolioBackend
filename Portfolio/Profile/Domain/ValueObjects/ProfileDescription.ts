import { StringValueObject } from '../../../Shared/Domain/StringValueObject';

export class ProfileDescription {
  private readonly value: StringValueObject;

  private constructor(description: string) {
    this.value = StringValueObject.create(description);
  }

  public static create(description: string) {
    return new ProfileDescription(description);
  }

  get description() {
    return this.value;
  }
}
