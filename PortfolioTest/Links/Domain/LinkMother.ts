import { Link } from '../../../Portfolio/Links/Domain/Link';
import { LinkId } from '../../../Portfolio/Links/Domain/ValueObject/LinkId';
import { LinkTitle } from '../../../Portfolio/Links/Domain/ValueObject/LinkTitle';
import { LinkUrl } from '../../../Portfolio/Links/Domain/ValueObject/LinkUrl';
import { Timestamp } from '../../../Portfolio/Shared/Domain/Timestamp';
import { SoftDelete } from '../../../Portfolio/Shared/Domain/SoftDelete';

export class LinkMother {
  static create(overrides?: {
    id?: string;
    title?: string;
    url?: string;
  }): Link {
    return Link.create(
      LinkId.create(overrides?.id ?? '550e8400-e29b-41d4-a716-446655440000'),
      LinkTitle.create(overrides?.title ?? 'GitHub Profile'),
      LinkUrl.create(overrides?.url ?? 'https://github.com/user'),
      Timestamp.now(),
      SoftDelete.no(),
    );
  }

}
