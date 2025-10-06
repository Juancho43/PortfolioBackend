import { SlugValueObject } from '../../../Shared/Domain/SlugValueObject';

export class EducationSlug {
  private readonly _value: SlugValueObject;

  private constructor(value: SlugValueObject) {
    this._value = value;
  }

  static create(value: string) {
    return new EducationSlug(SlugValueObject.create(value));
  }

  get value(): SlugValueObject {
    return this._value;
  }
}
