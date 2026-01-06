import { StringValueObject } from '../../../Shared/Domain/StringValueObject';

export class FileType {
  private readonly value: StringValueObject;

  private constructor(name: string) {
    this.value = StringValueObject.create(name);
  }

  public static create(name: string) {
    return new FileType(name);
  }

  get type() {
    return this.value;
  }
}
