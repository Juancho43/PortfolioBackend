import { IResponse } from '../../../Shared/Application/IResponse';
import { Tag } from '../../Domain/Tag';

export class TagResponse implements IResponse<Tag> {
  generate(data: Tag): any {
    return {
      id: data.id.getValue(),
      title: data.title.value.getValue(),
      createdAt: data.timestamp.getCreatedAt(),
      updatedAt: data.timestamp.getUpdatedAt(),
      deletedAt: data.softDelete.getDeletedAt(),
    };
  }
}
