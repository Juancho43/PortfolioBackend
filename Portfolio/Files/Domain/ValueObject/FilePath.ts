import { StringValueObject } from '../../../Shared/Domain/StringValueObject';

export class FilePath {
  private readonly value: StringValueObject;

  private constructor(name: string) {
    this.value = StringValueObject.create(name);
  }

  public static create(name: string) {
    return new FilePath(name);
  }

  get path() {
    return this.value;
  }
}
