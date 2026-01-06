import { CreateLinkRequest } from '../../../../Portfolio/Links/Application/DTO/CreateLinkRequest';
import { EditLinkRequest } from '../../../../Portfolio/Links/Application/DTO/EditLinkRequest';

describe('EditLinkRequest DTO', () => {
  it('should create an edit request instance with an id and nested create data', () => {
    // Arrange
    const id = 'uuid-test-123';
    const createData = new CreateLinkRequest(
      'Updated Title',
      'https://updated-url.com',
    );

    // Act
    const request = new EditLinkRequest(id, createData);

    // Assert
    expect(request.id).toBe(id);
    expect(request.data).toBeInstanceOf(CreateLinkRequest);
    expect(request.data.title).toBe('Updated Title');
    expect(request.data.url).toBe('https://updated-url.com');
  });

  it('should maintain referential integrity of the nested data object', () => {
    // Arrange
    const id = 'any-id';
    const createData = new CreateLinkRequest('Title', 'https://url.com');

    // Act
    const request = new EditLinkRequest(id, createData);

    // Assert
    // Verificamos que el objeto 'data' sea exactamente la misma instancia que pasamos
    expect(request.data).toBe(createData);
  });
});
