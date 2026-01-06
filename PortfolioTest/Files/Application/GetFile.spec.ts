import { GetFile } from '../../../Portfolio/Files/Application/GetFile';
import { FileMother } from '../../Files/Domain/FileMother';

describe('GetFile Use Case', () => {
  let repositoryMock: any;
  let useCase: GetFile;

  beforeEach(() => {
    // Creamos un mock del repositorio antes de cada test
    repositoryMock = {
      getById: jest.fn(),
    };
    useCase = new GetFile(repositoryMock);
  });

  it('should return a file when it exists in the repository', async () => {
    // Arrange
    const expectedFile = FileMother.create();
    const fileId = 'existing-uuid';
    repositoryMock.getById.mockResolvedValue(expectedFile);

    // Act
    const result = await useCase.execute(fileId);

    // Assert
    expect(repositoryMock.getById).toHaveBeenCalledWith(fileId);
    expect(result).toBe(expectedFile);
    expect(result.id).toEqual(expectedFile.id);
  });

  it('should throw an error when the file does not exist', async () => {
    // Arrange
    const fileId = 'non-existing-uuid';
    repositoryMock.getById.mockResolvedValue(null); // El repo devuelve null o undefined

    // Act & Assert
    await expect(useCase.execute(fileId)).rejects.toThrow('File not found');
    expect(repositoryMock.getById).toHaveBeenCalledWith(fileId);
  });
});