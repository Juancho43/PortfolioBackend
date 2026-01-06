import { IUseCase } from '../../Shared/Application/IUseCase';
import { File } from '../Domain/File';
import { GetFileByIdRepository } from '../Domain/Repository/GetFileByIdRepository';

export class GetFile implements IUseCase<string, Promise<File>> {
  constructor(private readonly repository: GetFileByIdRepository) {}

  async execute(arg: string): Promise<File> {
    const file = await this.repository.getById(arg);
    if (!file) {
      throw new Error('File not found');
    }
    return file;
  }
}
