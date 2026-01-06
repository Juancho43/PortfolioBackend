import { EditLink } from '../../../Portfolio/Links/Application/EditLink';
import { LinkMother } from '../Domain/LinkMother';
import { CreateLinkRequest } from '../../../Portfolio/Links/Application/DTO/CreateLinkRequest';
import { EditLinkRequest } from '../../../Portfolio/Links/Application/DTO/EditLinkRequest';

describe('EditLink Use Case', () => {
  let getLinkByIdMock: any;
  let repositoryMock: any;
  let useCase: EditLink;

  beforeEach(() => {
    // Mock del caso de uso GetLinkById
    getLinkByIdMock = { execute: jest.fn() };
    // Mock del puerto de persistencia
    repositoryMock = { save: jest.fn().mockResolvedValue(undefined) };

    useCase = new EditLink(getLinkByIdMock, repositoryMock);
  });

  it('should update link metadata and persist changes', async () => {
    // Arrange
    const existingLink = LinkMother.create();
    const linkId = existingLink.id.id.getValue();

    // Datos nuevos para la edición
    const updateData = new CreateLinkRequest(
      'Title Updated',
      'https://new-url.com',
    );
    const request = new EditLinkRequest(linkId, updateData);

    // Simulamos que el GetLinkById devuelve la entidad existente
    getLinkByIdMock.execute.mockResolvedValue(existingLink);

    // Act
    const result = await useCase.execute(request);

    // Assert
    // 1. Verificamos que se consultó la existencia del link
    expect(getLinkByIdMock.execute).toHaveBeenCalledWith(linkId);

    // 2. Verificamos que los valores de la entidad mutaron correctamente
    expect(result.title.value.getValue()).toBe('Title Updated');
    expect(result.url.value).toBe('https://new-url.com');

    // 3. Verificamos que se llamó al repositorio para guardar
    expect(repositoryMock.save).toHaveBeenCalledWith(existingLink);
  });

  it('should fail if the link to edit does not exist', async () => {
    // Arrange
    const request = new EditLinkRequest(
      'invalid-id',
      new CreateLinkRequest('T', 'U'),
    );

    // Simulamos que GetLinkById lanza el error de "not found"
    getLinkByIdMock.execute.mockRejectedValue(new Error('Link not found'));

    // Act & Assert
    await expect(useCase.execute(request)).rejects.toThrow('Link not found');
    expect(repositoryMock.save).not.toHaveBeenCalled();
  });
});
