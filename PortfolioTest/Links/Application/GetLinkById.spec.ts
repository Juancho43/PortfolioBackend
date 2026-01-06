import { GetLinkById } from '../../../Portfolio/Links/Application/GetLinkById';
import { LinkMother } from '../Domain/LinkMother';

describe('GetLinkById Use Case', () => {
  let repositoryMock: any;
  let useCase: GetLinkById;

  beforeEach(() => {
    // Definimos el mock del repositorio con el método exacto definido en tu clase
    repositoryMock = {
      getLinkById: jest.fn(),
    };
    useCase = new GetLinkById(repositoryMock);
  });

  it('should return a Link entity when it exists in the repository', async () => {
    // Arrange
    const expectedLink = LinkMother.create();
    const linkId = 'valid-uuid';
    repositoryMock.getLinkById.mockResolvedValue(expectedLink);

    // Act
    const result = await useCase.execute(linkId);

    // Assert
    expect(repositoryMock.getLinkById).toHaveBeenCalledWith(linkId);
    expect(result).toBe(expectedLink);
    // Validamos que el acceso a los Value Objects sea el esperado según tu entidad
    expect(result.id.id.getValue()).toBe(expectedLink.id.id.getValue());
  });

  it('should throw an error when the link is not found', async () => {
    // Arrange
    const linkId = 'non-existent-uuid';
    repositoryMock.getLinkById.mockResolvedValue(null);

    // Act & Assert
    await expect(useCase.execute(linkId)).rejects.toThrow('Link not found');
    expect(repositoryMock.getLinkById).toHaveBeenCalledWith(linkId);
  });
});
