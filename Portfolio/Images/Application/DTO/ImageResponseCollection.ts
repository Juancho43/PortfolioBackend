import { Image } from '../../Domain/Image';
import { IResponse } from '../../../Shared/Application/IResponse';
import { ImageResponse } from './ImageResponse';

export class ImageResponseCollection implements IResponse<Image[]> {
  generate(data: Image[]): any {
    if (!Array.isArray(data)) return [];
    const presenter = new ImageResponse();
    return data.map((image) => presenter.generate(image));
  }
}
