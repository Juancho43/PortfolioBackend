import { IResponse } from '../../../Shared/Application/IResponse';
import { Link } from '../../Domain/Link';

export class LinkResponse implements IResponse<Link> {
  generate(data: Link): any {
    return {
      id: data.id.id.getValue(),
      title: data.title.value.getValue(),
      url: data.url.value,
      createdAt: data.timestamp.getCreatedAt(),
      updatedAt: data.timestamp.getUpdatedAt(),
      deletedAt: data.softdelete.getDeletedAt(),
    };
  }
}
