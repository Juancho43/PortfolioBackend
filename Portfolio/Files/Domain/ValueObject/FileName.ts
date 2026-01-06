import { StringValueObject } from '../../../Shared/Domain/StringValueObject';

export class FileName {
  private readonly value: StringValueObject;

  private constructor(name: string) {
    this.value = StringValueObject.create(name);
  }

  public static create(name: string) {
    return new FileName(name);
  }

  get name() {
    return this.value;
  }
}
