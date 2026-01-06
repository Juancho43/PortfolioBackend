import { StringValueObject } from '../../../Shared/Domain/StringValueObject';

export class ProfileName {
  private readonly value: StringValueObject;

  private constructor(name: string) {
    this.value = StringValueObject.create(name);
  }

  public static create(name: string) {
    return new ProfileName(name);
  }

  get name() {
    return this.value;
  }
}
