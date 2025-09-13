import { StringValueObject } from '../../../Shared/Domain/StringValueObject';

export class EducationTitle {
  private readonly _value: StringValueObject;

  private constructor(value: StringValueObject) {
    this._value = value;
  }
  static create(value: string){
    return new EducationTitle(StringValueObject.create(value));
  }
  get value(): StringValueObject {
    return this._value;
  }
}
