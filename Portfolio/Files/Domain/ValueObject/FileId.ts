import { IdValueObject } from '../../../Shared/Domain/IdValueObject';

export class FileId {
  private readonly id: IdValueObject;

  private constructor(id: string) {
    this.id = IdValueObject.create(id);
  }

  public static create(id: string) {
    return new FileId(id);
  }
  get fileId() {
    return this.id;
  }
}
