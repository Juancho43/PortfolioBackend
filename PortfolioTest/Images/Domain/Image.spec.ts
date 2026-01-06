import { ImageId } from '../../../Portfolio/Images/Domain/ValueObject/ImageId';
import { FileMother } from '../../Files/Domain/FileMother';
import { ImageWidth } from '../../../Portfolio/Images/Domain/ValueObject/ImageWidth';
import { ImageHeight } from '../../../Portfolio/Images/Domain/ValueObject/ImageHeight';
import { Image } from '../../../Portfolio/Images/Domain/Image';
import { SoftDelete } from '../../../Portfolio/Shared/Domain/SoftDelete';
import { Timestamp } from '../../../Portfolio/Shared/Domain/Timestamp';

describe('Image Entity', () => {
  it('should create an Image instance using the static create method', () => {
    // Arrange
    const id = ImageId.create('image-uuid-123');
    const file = FileMother.create(); // Reutilizamos el Mother de File
    const width = ImageWidth.create(1920);
    const height = ImageHeight.create(1080);

    // Act
    const image = Image.create(id, file, width, height, Timestamp.now(), SoftDelete.no());

    // Assert
    expect(image).toBeInstanceOf(Image);
    expect(image.id.getValue()).toBe('image-uuid-123');
    expect(image.file).toBe(file);
    expect(image.width.getValue()).toBe(1920);
    expect(image.height.getValue()).toBe(1080);
  });



  it('should maintain the relationship with the File entity', () => {
    // Arrange
    const file = FileMother.create({ name: 'logo.png' });
    const image = Image.create(
      ImageId.create('id123-123'),
      file,
      ImageWidth.create(500),
      ImageHeight.create(500),
      Timestamp.now(),
      SoftDelete.no(),
    );

    // Assert
    expect(image.file.name.name.getValue()).toBe('logo.png');
  });
});
