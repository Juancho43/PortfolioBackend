import { DeleteFile } from '../../../Portfolio/Files/Application/DeleteFile';
import { FileMother } from '../../Files/Domain/FileMother';

describe('DeleteFile Use Case', () => {
  let getFileMock: any;
  let repositoryMock: any;
  let storageMock: any;
  let useCase: DeleteFile;

  beforeEach(() => {
    // Mock del caso de uso GetFile
    getFileMock = { execute: jest.fn() };
    // Mocks de los puertos (interfaces)
    repositoryMock = { deleteById: jest.fn() };
    storageMock = { execute: jest.fn() };

    useCase = new DeleteFile(getFileMock, repositoryMock, storageMock);
  });

  it('should delete the file from repository and storage when it exists', async () => {
    // Arrange
    const fileId = 'any-uuid';
    const fileEntity = FileMother.create(); // Entidad con su path, etc.

    // Simulamos que GetFile encuentra el archivo con éxito
    getFileMock.execute.mockResolvedValue(fileEntity);
    repositoryMock.deleteById.mockResolvedValue(undefined);
    storageMock.execute.mockResolvedValue(undefined);

    // Act
    await useCase.execute(fileId);

    // Assert
    // 1. Verificamos que primero intenta obtener el archivo
    expect(getFileMock.execute).toHaveBeenCalledWith(fileId);

    // 2. Verificamos que se borra de la DB
    expect(repositoryMock.deleteById).toHaveBeenCalledWith(fileId);

    // 3. Verificamos que se borra del Storage físico usando el path de la entidad
    expect(storageMock.execute).toHaveBeenCalledWith(
      fileEntity.path.path.getValue(),
    );
  });

  it('should stop execution if the file is not found (GetFile throws error)', async () => {
    // Arrange
    const fileId = 'non-existent-id';
    // Simulamos que GetFile lanza el error que definiste antes
    getFileMock.execute.mockRejectedValue(new Error('File not found'));

    // Act & Assert
    await expect(useCase.execute(fileId)).rejects.toThrow('File not found');

    // Verificamos que NUNCA se llamó al repositorio ni al storage si falló el GetFile
    expect(repositoryMock.deleteById).not.toHaveBeenCalled();
    expect(storageMock.execute).not.toHaveBeenCalled();
  });
});
