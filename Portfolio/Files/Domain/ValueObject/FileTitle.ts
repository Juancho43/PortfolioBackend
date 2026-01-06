import { StringValueObject } from '../../../Shared/Domain/StringValueObject';

export class FileTitle {
  private readonly value: StringValueObject;

  private constructor(name: string) {
    this.value = StringValueObject.create(name);
  }

  public static create(name: string) {
    return new FileTitle(name);
  }

  get title() {
    return this.value;
  }
}
