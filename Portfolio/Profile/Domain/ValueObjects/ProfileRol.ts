import { StringValueObject } from '../../../Shared/Domain/StringValueObject';

export class ProfileRole {
  private readonly value: StringValueObject;

  private constructor(role: string) {
    this.value = StringValueObject.create(role);
  }

  public static create(role: string) {
    return new ProfileRole(role);
  }

  get role() {
    return this.value;
  }
}
