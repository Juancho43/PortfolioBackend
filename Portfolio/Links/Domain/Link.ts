import { LinkId } from './ValueObject/LinkId';
import { LinkTitle } from './ValueObject/LinkTitle';
import { LinkUrl } from './ValueObject/LinkUrl';
import { Timestamp } from '../../Shared/Domain/Timestamp';
import { SoftDelete } from '../../Shared/Domain/SoftDelete';

export class Link {
  private id: LinkId;
  private title: LinkTitle;
  private url: LinkUrl;
  private timestamp: Timestamp;
  private softdelete: SoftDelete;
}
