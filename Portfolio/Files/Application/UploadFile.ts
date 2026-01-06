import { IUseCase } from '../../Shared/Application/IUseCase';
import { SaveFileStorage } from '../Domain/Storage/SaveFileStorage';
import { SaveFileRepository } from '../Domain/Repository/SaveFileRepository';
import { UploadFileRequest } from './DTO/UploadFileRequest';
import { File } from '../Domain/File';
import { randomUUID } from 'node:crypto';
import { FileId } from '../Domain/ValueObject/FileId';
import { FileName } from '../Domain/ValueObject/FileName';
import { FileSize } from '../Domain/ValueObject/FileSize';
import { FileType } from '../Domain/ValueObject/FileType';
import { FilePath } from '../Domain/ValueObject/FilePath';
import { FileTitle } from '../Domain/ValueObject/FileTitle';
import { FileAlt } from '../Domain/ValueObject/FileAlt';
export class UploadFile implements IUseCase<UploadFileRequest, Promise<File>> {
  constructor(
    private readonly storage: SaveFileStorage,
    private readonly repository: SaveFileRepository,
  ) {}
  async execute(arg: UploadFileRequest): Promise<File> {
    const file = File.create(
      FileId.create(randomUUID().toString()),
      FileName.create(arg.name),
      FileSize.fromBytes(arg.size),
      FileType.create(arg.type),
      FilePath.create('temp/path/' + arg.name),
      FileTitle.create(arg.name),
      FileAlt.create(arg.name),
    );

    await this.storage.save(file.path.path.getValue(), arg.buffer);

    // 2. Guardar metadatos en DB
    await this.repository.save(file);
    return file;
  }
}
