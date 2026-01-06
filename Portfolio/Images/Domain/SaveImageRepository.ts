import { Image } from './Image';

export interface SaveImageRepository {
  save(image: Image): Promise<void>;
}
