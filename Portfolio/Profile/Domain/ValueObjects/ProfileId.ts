import { IdValueObject } from '../../../Shared/Domain/IdValueObject';

export class ProfileId {
  private readonly id: IdValueObject;

  private constructor(id: string) {
    this.id = IdValueObject.create(id);
  }

  public static create(id: string) {
    return new ProfileId(id);
  }
  get profileId() {
    return this.id;
  }
}
