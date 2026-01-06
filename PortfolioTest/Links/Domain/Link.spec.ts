import { LinkMother } from './LinkMother';
import { Link } from '../../../Portfolio/Links/Domain/Link';
import { LinkTitle } from '../../../Portfolio/Links/Domain/ValueObject/LinkTitle';
import { LinkUrl } from '../../../Portfolio/Links/Domain/ValueObject/LinkUrl';
import { SoftDelete } from '../../../Portfolio/Shared/Domain/SoftDelete';

describe('Link Entity', () => {
  it('should be created correctly through static create method', () => {
    const link = LinkMother.create({
      title: 'LinkedIn',
      url: 'https://linkedin.com/in/user',
    });

    expect(link).toBeInstanceOf(Link);
    // Accedemos a los Value Objects para validar el valor primitivo final
    expect(link.title.value.getValue()).toBe('LinkedIn');
    expect(link.url.value).toBe('https://linkedin.com/in/user');
    expect(link.softdelete.getDeletedAt()).toBeNull();
  });

  it('should allow updating title and url through setters', () => {
    const link = LinkMother.create();
    const newTitle = LinkTitle.create('New Portfolio');
    const newUrl = LinkUrl.create('https://portfolio.me');

    link.title = newTitle;
    link.url = newUrl;

    expect(link.title.value.getValue()).toBe('New Portfolio');
    expect(link.url.value).toBe('https://portfolio.me');
  });

  it('should handle timestamp and softdelete objects', () => {
    const link = LinkMother.create();

    expect(link.timestamp.getCreatedAt()).toBeInstanceOf(Date);
    expect(link.softdelete.getDeletedAt()).toBeNull();
  });

  it('should reflect changes in softdelete when updated', () => {
    const link = LinkMother.create();

    // Asumiendo que tu VO SoftDelete tiene un método estático o constructor
    // para crear una instancia con fecha de borrado
    const deletedStatus = SoftDelete.yes();

    link.softdelete = deletedStatus;

    expect(link.softdelete.getDeletedAt()).toEqual(deletedStatus.getDeletedAt());
  });
});
