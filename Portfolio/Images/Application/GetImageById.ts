import { IUseCase } from '../../Shared/Application/IUseCase';
import { Image } from '../Domain/Image';
import { GetImageRepository } from '../Domain/GetImageRepository';

export class GetImageById implements IUseCase<string, Promise<Image>> {
  constructor(
    private readonly repository: GetImageRepository,
  ) {}

  async execute(id: string): Promise<Image> {
    const image = await this.repository.getImageById(id);
    if (!image) {
      throw new Error('Image not found');
    }
    return image;
  }
}
