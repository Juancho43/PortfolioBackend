import { SlugValueObject } from '../../../Shared/Domain/SlugValueObject';

export class ProjectSlug {
  private readonly _value: SlugValueObject;

  private constructor(value: SlugValueObject) {
    this._value = value;
  }

  static create(value: string) {
    return new ProjectSlug(SlugValueObject.create(value));
  }

  get value(): SlugValueObject {
    return this._value;
  }
}
