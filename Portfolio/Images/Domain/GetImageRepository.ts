import { Image } from './Image';

export interface GetImageRepository {
  getImageById(id: string): Promise<Image | null>;
}
