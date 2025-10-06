import { StringValueObject } from '../../../Shared/Domain/StringValueObject';

export class LinkTitle {
  get value(): StringValueObject {
    return this._value;
  }
  private _value: StringValueObject;

  constructor(value: StringValueObject) {
    this._value = value;
  }
  static create(value: string){
    return new LinkTitle(StringValueObject.create(value));
  }
}
