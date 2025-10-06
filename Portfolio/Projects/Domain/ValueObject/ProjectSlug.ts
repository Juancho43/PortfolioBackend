import { SlugValueObject } from '../../../Shared/Domain/SlugValueObject';

export class ProjectSlug {
  private value: SlugValueObject;

  private constructor(value: SlugValueObject) {
    this.value = value;
  }

  static create(value: SlugValueObject) {
    return new ProjectSlug(value);
  }
}
