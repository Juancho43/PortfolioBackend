import { IUseCase } from '../../Shared/Application/IUseCase';
import { DeleteFileByIdRepository } from '../Domain/Repository/DeleteFileByIdRepository';
import { DeleteFileStorage } from '../Domain/Storage/DeleteFileStorage';
import { GetFile } from './GetFile';

export class DeleteFile implements IUseCase<string, Promise<void>> {
  constructor(
    private readonly get: GetFile,
    private readonly repository: DeleteFileByIdRepository,
    private readonly storage: DeleteFileStorage,
  ) {}

  async execute(fileId: string): Promise<void> {
    const file = await this.get.execute(fileId);
    await this.repository.deleteById(fileId);
    await this.storage.execute(file.path.path.getValue());
  }
}
