import { FileType } from './ValueObject/FileType';
import { FileTitle } from './ValueObject/FileTitle';
import { FilePath } from './ValueObject/FilePath';
import { FileName } from './ValueObject/FileName';
import { FileSize } from './ValueObject/FileSize';
import { FileId } from './ValueObject/FileId';
import { FileAlt } from './ValueObject/FileAlt';

export class File {
  private constructor(
    private _id: FileId,
    private _name: FileName,
    private _size: FileSize,
    private _type: FileType,
    private _path: FilePath,
    private _title: FileTitle,
    private _alt: FileAlt,
    private _buffer?: Buffer,
  ) {}

  public static create(
    id: FileId,
    name: FileName,
    size: FileSize,
    type: FileType,
    path: FilePath,
    title: FileTitle,
    alt: FileAlt,
  ): File {
    return new File(id, name, size, type, path, title, alt);
  }

  get buffer(): Buffer | undefined {
    return this._buffer;
  }

  set buffer(buffer: Buffer) {
    this._buffer = buffer;
  }

  get id(): FileId {
    return this._id;
  }

  set id(value: FileId) {
    this._id = value;
  }

  get name(): FileName {
    return this._name;
  }

  set name(value: FileName) {
    this._name = value;
  }

  get size(): FileSize {
    return this._size;
  }

  set size(value: FileSize) {
    this._size = value;
  }

  get type(): FileType {
    return this._type;
  }

  set type(value: FileType) {
    this._type = value;
  }

  get path(): FilePath {
    return this._path;
  }

  set path(value: FilePath) {
    this._path = value;
  }

  get title(): FileTitle {
    return this._title;
  }

  set title(value: FileTitle) {
    this._title = value;
  }

  get alt(): FileAlt {
    return this._alt;
  }

  set alt(value: FileAlt) {
    this._alt = value;
  }
}
