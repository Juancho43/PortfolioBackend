import { IResponse } from '../../../Shared/Application/IResponse';
import { Image } from '../../Domain/Image';
import { FileResponse } from '../../../Files/Application/DTO/FileResponse';

export class ImageResponse implements IResponse<Image> {
  generate(data: Image): any {
    return {
      id: data.id.getValue(),
      width: data.width.getValue(),
      height: data.height.getValue(),
      // Reutilizamos el presenter de File para los datos del archivo
      file: new FileResponse().generate(data.file),
    };
  }
}
