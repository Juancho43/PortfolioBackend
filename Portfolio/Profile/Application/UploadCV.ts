import { IUseCase } from '../../Shared/Application/IUseCase';
import { UploadFile } from '../../Files/Application/UploadFile';
import { SaveProfileRepository } from '../Domain/SaveProfileRepository';
import { UploadCvRequest } from './DTO/UploadCvRequest';
import { GetProfileById } from './GetProfileById';
import { File } from '../../Files/Domain/File';

export class UploadCV implements IUseCase<UploadCvRequest, Promise<File>> {
  constructor(
    private readonly get: GetProfileById,
    private readonly uploadFile: UploadFile,
    private readonly repository: SaveProfileRepository,
  ) {}

  async execute(arg: UploadCvRequest): Promise<File> {
    const profile = await this.get.execute(arg.profileId);
    profile.cv = await this.uploadFile.execute(arg.file);
    await this.repository.execute(profile);
    return profile.cv;
  }
}
