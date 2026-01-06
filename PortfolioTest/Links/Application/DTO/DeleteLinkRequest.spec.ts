import { DeleteLinkRequest } from '../../../../Portfolio/Links/Application/DTO/DeleteLinkRequest';

describe('DeleteLinkRequest DTO', () => {
  it('should create a delete request instance with the provided id', () => {
    // Arrange
    const id = '550e8400-e29b-41d4-a716-446655440000';

    // Act
    const request = new DeleteLinkRequest(id);

    // Assert
    expect(request.id).toBe(id);
    expect(request).toBeInstanceOf(DeleteLinkRequest);
  });

  it('should store the id as a string', () => {
    // Arrange
    const id = 'any-id-string';

    // Act
    const request = new DeleteLinkRequest(id);

    // Assert
    expect(typeof request.id).toBe('string');
  });
});
