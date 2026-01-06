import { ImageId } from './ValueObject/ImageId';
import { ImageWidth } from './ValueObject/ImageWidth';
import { ImageHeight } from './ValueObject/ImageHeight';
import { File } from '../../Files/Domain/File';
import { SoftDelete } from '../../Shared/Domain/SoftDelete';
import { Timestamp } from '../../Shared/Domain/Timestamp';

export class Image {
  private constructor(
    private readonly _id: ImageId,
    private readonly _file: File,
    private readonly _width: ImageWidth,
    private readonly _height: ImageHeight,
    private _timestamp: Timestamp,
    private _softdeleted: SoftDelete,
  ) {}

  public static create(
    id: ImageId,
    file: File,
    width: ImageWidth,
    height: ImageHeight,
    timestamp: Timestamp,
    softdeleted: SoftDelete,
  ): Image {
    return new Image(id, file, width, height, timestamp, softdeleted);
  }

  get id(): ImageId {
    return this._id;
  }
  get file(): File {
    return this._file;
  }
  get width(): ImageWidth {
    return this._width;
  }
  get height(): ImageHeight {
    return this._height;
  }

  // CORRECCIÓN: Añadir guion bajo (_) a las propiedades internas
  get timestamp(): Timestamp {
    return this._timestamp;
  }

  set timestamp(value: Timestamp) {
    this._timestamp = value;
  }

  get softdeleted(): SoftDelete {
    return this._softdeleted;
  }

  set softdeleted(value: SoftDelete) {
    this._softdeleted = value;
  }
}
