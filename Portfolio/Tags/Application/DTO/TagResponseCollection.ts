import { IResponse } from '../../../Shared/Application/IResponse';
import { Tag } from '../../Domain/Tag';
import { TagResponse } from './TagResponse';

export class TagResponseCollection implements IResponse<Tag[]> {
  generate(data: Tag[]): any {
    if (!Array.isArray(data)) return [];
    return data.map((tag) => new TagResponse().generate(tag));
  }
}
