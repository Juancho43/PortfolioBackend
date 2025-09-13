import { IdValueObject } from '../../../Shared/Domain/IdValueObject';

export class EducationId {
  private readonly _id: IdValueObject;

  private constructor(id: IdValueObject) {
    this._id = id;
  }

  static create(value: string){
    return new EducationId(IdValueObject.create(value));
  }

  get id(): IdValueObject {
    return this._id;
  }
}
