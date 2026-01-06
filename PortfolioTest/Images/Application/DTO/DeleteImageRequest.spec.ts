import { DeleteImageRequest } from '../../../../Portfolio/Images/Application/DTO/DeleteImageRequest';

describe('DeleteImageRequest DTO', () => {
  it('should create a delete image request instance with the provided id', () => {
    // Arrange
    const id = 'image-uuid-999';

    // Act
    const request = new DeleteImageRequest(id);

    // Assert
    expect(request.id).toBe(id);
    expect(request).toBeInstanceOf(DeleteImageRequest);
  });

  it('should ensure the id is passed correctly as a string', () => {
    // Arrange
    const id = 'another-uuid';

    // Act
    const request = new DeleteImageRequest(id);

    // Assert
    expect(typeof request.id).toBe('string');
    expect(request.id).toEqual(id);
  });
});
