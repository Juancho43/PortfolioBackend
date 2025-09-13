import { StringValueObject } from '../../../Shared/Domain/StringValueObject';

export class TagTitle {
  private value: StringValueObject;

  constructor(value: StringValueObject) {
    this.value = value;
  }
  public static create(value: string){
    return new TagTitle(StringValueObject.create(value));
  }
}
