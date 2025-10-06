import { IdValueObject } from '../../../Shared/Domain/IdValueObject';

export class LinkId {
  get id(): IdValueObject {
    return this._id;
  }
  private _id: IdValueObject;

  private constructor(id: IdValueObject) {
    this._id = id;
  }
  static create(id: string) {
    return new LinkId(IdValueObject.create(id));
  }
}
