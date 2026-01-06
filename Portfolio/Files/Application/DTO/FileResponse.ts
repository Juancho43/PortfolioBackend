import { IResponse } from '../../../Shared/Application/IResponse';
import { File } from '../../Domain/File';

export class FileResponse implements IResponse<File> {
  generate(data: File): any {
    return {
      id: data.id.fileId.getValue(),
      name: data.name.name.getValue(),
      size: data.size.toString(),
      type: data.type.type.getValue(),
      path: data.path.path.getValue(),
      title: data.title.title.getValue(),
      alt: data.alt.alt.getValue(),
    };
  }
}
