import { Link } from './Link';

export interface GetLinkRepository {
  getLinkById(id: string): Promise<Link>;
}
