import { StringValueObject } from '../../../Shared/Domain/StringValueObject';

export class FileAlt {
  private readonly value: StringValueObject;

  private constructor(name: string) {
    this.value = StringValueObject.create(name);
  }

  public static create(name: string) {
    return new FileAlt(name);
  }

  get alt() {
    return this.value;
  }
}
