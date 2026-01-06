import { IResponse } from '../../Shared/Application/IResponse';
import { Link } from '../Domain/Link';
import { LinkResponse } from './LinkResponse';

export class LinkResponseCollection implements IResponse<Link[]> {
  generate(data: Link[]): any {
    if (!Array.isArray(data)) return [];
    return data.map((link) => {
      return new LinkResponse().generate(link);
    });
  }
}
