import { DeleteLink } from '../../../Portfolio/Links/Application/DeleteLink';
import { LinkMother } from '../Domain/LinkMother';
import { DeleteLinkRequest } from '../../../Portfolio/Links/Application/DTO/DeleteLinkRequest';

describe('DeleteLink Use Case', () => {
  let getLinkByIdMock: any;
  let repositoryMock: any;
  let useCase: DeleteLink;

  beforeEach(() => {
    getLinkByIdMock = { execute: jest.fn() };
    repositoryMock = { save: jest.fn().mockResolvedValue(undefined) };
    useCase = new DeleteLink(getLinkByIdMock, repositoryMock);
  });

  it('should mark a link as deleted (soft delete) and save the change', async () => {
    // Arrange
    const existingLink = LinkMother.create();
    const linkId = 'uuid-to-delete';
    const request = new DeleteLinkRequest(linkId);

    // Verificamos que inicialmente NO esté borrado
    expect(existingLink.softdelete.getDeletedAt()).toBeNull();

    getLinkByIdMock.execute.mockResolvedValue(existingLink);

    // Act
    await useCase.execute(request);

    // Assert
    // 1. Verificamos que buscó el link por ID
    expect(getLinkByIdMock.execute).toHaveBeenCalledWith(linkId);

    // 2. Verificamos que el estado de la entidad cambió a "deleted"
    // (Asumiendo que tu VO SoftDelete devuelve una fecha cuando llamas a .delete())
    expect(existingLink.softdelete.getDeletedAt()).toBeInstanceOf(Date);

    // 3. Verificamos que se persistió la entidad con el nuevo estado
    expect(repositoryMock.save).toHaveBeenCalledWith(existingLink);
  });

  it('should not attempt to save if the link is not found', async () => {
    // Arrange
    const request = new DeleteLinkRequest('invalid-id');
    getLinkByIdMock.execute.mockRejectedValue(new Error('Link not found'));

    // Act & Assert
    await expect(useCase.execute(request)).rejects.toThrow('Link not found');
    expect(repositoryMock.save).not.toHaveBeenCalled();
  });
});
