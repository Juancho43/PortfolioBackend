import { ImageResponseCollection } from '../../../../Portfolio/Images/Application/DTO/ImageResponseCollection';
import { ImageMother } from '../../Domain/ImageMother';

describe('ImageResponseCollection', () => {
  let collectionPresenter: ImageResponseCollection;

  beforeEach(() => {
    collectionPresenter = new ImageResponseCollection();
  });

  it('should transform an array of Image entities', () => {
    // Arrange
    const images = [
      ImageMother.create({ id: 'img-1' }),
      ImageMother.create({ id: 'img-2' }),
    ];

    // Act
    const result = collectionPresenter.generate(images);

    // Assert
    expect(result).toHaveLength(2);
    expect(result[0].id).toBe('img-1');
    expect(result[1].id).toBe('img-2');
  });

  it('should return an empty array if input is empty or invalid', () => {
    expect(collectionPresenter.generate([])).toEqual([]);
    expect(collectionPresenter.generate(null as any)).toEqual([]);
  });
});
