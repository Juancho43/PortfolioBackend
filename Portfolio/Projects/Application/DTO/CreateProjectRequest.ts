import { Tag } from '../../../Tags/Domain/Tag';
import { Link } from '../../../Links/Domain/Link';

export class CreateProjectRequest {
  constructor(
    public title: string,
    public description: string,
    public pinned: boolean = false,
    public links: Link[] = [],
    public tags: Tag[] = [],
  ) {}
}
