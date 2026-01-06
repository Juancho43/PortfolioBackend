import { CreateLink } from '../../../Portfolio/Links/Application/CreateLink';
import { CreateLinkRequest } from '../../../Portfolio/Links/Application/DTO/CreateLinkRequest';
import { Link } from '../../../Portfolio/Links/Domain/Link';

describe('CreateLink Use Case', () => {
  let repositoryMock: any;
  let useCase: CreateLink;

  beforeEach(() => {
    repositoryMock = {
      save: jest.fn().mockResolvedValue(undefined),
    };
    useCase = new CreateLink(repositoryMock);
  });

  it('should create a new Link and save it in the repository', async () => {
    // Arrange
    const request = new CreateLinkRequest(
      'My GitHub',
      'https://github.com/myuser',
    );

    // Act
    const result = await useCase.execute(request);

    // Assert
    // 1. Verificamos que el resultado sea una instancia de Link
    expect(result).toBeInstanceOf(Link);

    // 2. Verificamos que los datos coincidan con el request
    // (Ajusta la cadena de métodos .value.getValue() según tus Value Objects)
    expect(result.title.value.getValue()).toBe(request.title);
    expect(result.url.value).toBe(request.url);

    // 3. Verificamos que se haya generado un ID
    expect(result.id.id.getValue()).toBeDefined();

    // 4. Verificamos la llamada al repositorio
    expect(repositoryMock.save).toHaveBeenCalledWith(result);
  });

  it('should initialize the link with current timestamp and no soft delete', async () => {
    // Arrange
    const request = new CreateLinkRequest('Title', 'https://url.com');

    // Act
    const result = await useCase.execute(request);

    // Assert
    expect(result.timestamp.getCreatedAt()).toBeInstanceOf(Date);
    expect(result.softdelete.getDeletedAt()).toBeNull();
  });
});
