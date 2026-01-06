import { ImageResponse } from '../../../../Portfolio/Images/Application/DTO/ImageResponse';
import { ImageMother } from '../../Domain/ImageMother';

describe('ImageResponse', () => {
  it('should map an Image entity to a plain response object', () => {
    // Arrange
    const presenter = new ImageResponse();
    const image = ImageMother.create({
      id: 'img-123',
      width: 1920,
      height: 1080,
    });

    // Act
    const result = presenter.generate(image);

    // Assert
    expect(result).toEqual({
      id: 'img-123',
      width: 1920,
      height: 1080,
      file: expect.objectContaining({
        id: image.file.id.fileId.getValue(),
        name: image.file.name.name.getValue(),
      }),
    });
  });
});
