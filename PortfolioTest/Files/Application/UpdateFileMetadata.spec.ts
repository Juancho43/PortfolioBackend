import { UpdateFileMetadata } from '../../../Portfolio/Files/Application/UpdateFileMetada';
import { UpdateFileRequest } from '../../../Portfolio/Files/Application/DTO/UpdateFileRequest';
import { FileMother } from '../Domain/FileMother';

describe('UpdateFileMetadata Use Case', () => {
  let getFileMock: any;
  let repositoryMock: any;
  let useCase: UpdateFileMetadata;

  beforeEach(() => {
    getFileMock = { execute: jest.fn() };
    repositoryMock = { save: jest.fn() };
    useCase = new UpdateFileMetadata(getFileMock, repositoryMock);
  });

  it('should update file metadata and save it', async () => {
    // Arrange
    const existingFile = FileMother.create();
    const request = new UpdateFileRequest(
      existingFile.id.fileId.getValue(),
      'Nuevo Titulo',
      'Nuevo Alt',
    );

    getFileMock.execute.mockResolvedValue(existingFile);
    repositoryMock.save.mockResolvedValue(existingFile);

    // Act
    const result = await useCase.execute(request);

    // Assert
    // 1. Verificamos que buscó el archivo correcto
    expect(getFileMock.execute).toHaveBeenCalledWith(request.id);

    // 2. Verificamos que los datos en la entidad cambiaron
    // (Asumiendo que tus Value Objects guardan el valor en .value)
    expect(result.title.title.getValue()).toBe(request.title);
    expect(result.alt.alt.getValue()).toBe(request.alt);

    // 3. Verificamos que se persistió la entidad actualizada
    expect(repositoryMock.save).toHaveBeenCalledWith(existingFile);
  });

  it('should fail if the file to update does not exist', async () => {
    // Arrange
    const request = new UpdateFileRequest('invalid-id', 'T', 'A');
    getFileMock.execute.mockRejectedValue(new Error('File not found'));

    // Act & Assert
    await expect(useCase.execute(request)).rejects.toThrow('File not found');
    expect(repositoryMock.save).not.toHaveBeenCalled();
  });
});
