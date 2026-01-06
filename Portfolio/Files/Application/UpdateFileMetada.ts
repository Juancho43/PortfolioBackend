import { IUseCase } from '../../Shared/Application/IUseCase';
import { UpdateFileRequest } from './DTO/UpdateFileRequest';
import { GetFile } from './GetFile';
import { SaveFileRepository } from '../Domain/Repository/SaveFileRepository';
import { FileTitle } from '../Domain/ValueObject/FileTitle';
import { FileAlt } from '../Domain/ValueObject/FileAlt';
import { File } from '../Domain/File';

export class UpdateFileMetadata
  implements IUseCase<UpdateFileRequest, Promise<File>>
{
  constructor(
    private readonly get: GetFile,
    private readonly repository: SaveFileRepository,
  ) {}

  async execute(request: UpdateFileRequest): Promise<File> {
    const file = await this.get.execute(request.id);
    file.title = FileTitle.create(request.title);
    file.alt = FileAlt.create(request.alt);
    await this.repository.save(file);
    return file;
  }
}
