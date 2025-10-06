import { StringValueObject } from '../../../Shared/Domain/StringValueObject';

export class TagTitle {
  private _value: StringValueObject;

  constructor(value: StringValueObject) {
    this._value = value;
  }
  public static create(value: string) {
    return new TagTitle(StringValueObject.create(value));
  }

  get value(): StringValueObject {
    return this._value;
  }
}
