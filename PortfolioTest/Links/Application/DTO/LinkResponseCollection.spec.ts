import { LinkResponseCollection } from '../../../../Portfolio/Links/Application/DTO/LinkResponseCollection';
import { LinkMother } from '../../Domain/LinkMother';

describe('LinkResponseCollection', () => {
  let collectionPresenter: LinkResponseCollection;

  beforeEach(() => {
    collectionPresenter = new LinkResponseCollection();
  });

  it('should transform an array of Link entities into an array of plain objects', () => {
    // Arrange
    const links = [
      LinkMother.create({ title: 'Link 1' }),
      LinkMother.create({ title: 'Link 2' }),
      LinkMother.create({ title: 'Link 3' }),
    ];

    // Act
    const result = collectionPresenter.generate(links);

    // Assert
    expect(Array.isArray(result)).toBe(true);
    expect(result).toHaveLength(3);

    // Verificamos que los datos mapeados coincidan con el formato esperado de LinkResponse
    expect(result[0].title).toBe('Link 1');
    expect(result[1].title).toBe('Link 2');
    expect(result[2].title).toBe('Link 3');
  });

  it('should return an empty array if the input is an empty array', () => {
    // Act
    const result = collectionPresenter.generate([]);

    // Assert
    expect(result).toEqual([]);
  });

  it('should return an empty array if the input is not an array (safety check)', () => {
    // Act
    const result = collectionPresenter.generate(null as any);

    // Assert
    expect(result).toEqual([]);
  });

  it('should maintain the structure of LinkResponse for each element', () => {
    // Arrange
    const links = [LinkMother.create()];

    // Act
    const result = collectionPresenter.generate(links);

    // Assert
    // Verificamos que tenga las llaves básicas que definiste en LinkResponse
    expect(result[0]).toHaveProperty('id');
    expect(result[0]).toHaveProperty('title');
    expect(result[0]).toHaveProperty('url');
    expect(result[0]).toHaveProperty('createdAt');
  });
});
