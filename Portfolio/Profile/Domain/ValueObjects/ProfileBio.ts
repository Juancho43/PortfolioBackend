import { StringValueObject } from '../../../Shared/Domain/StringValueObject';

export class ProfileBio {
  private readonly value: StringValueObject;

  private constructor(bio: string) {
    this.value = StringValueObject.create(bio);
  }

  public static create(bio: string) {
    return new ProfileBio(bio);
  }

  get bio() {
    return this.value;
  }
}
