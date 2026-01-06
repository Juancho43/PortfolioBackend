import { UploadFile } from '../../../Portfolio/Files/Application/UploadFile';
import { FileMother } from '../Domain/FileMother';
import { UploadFileRequest } from '../../../Portfolio/Files/Application/DTO/UploadFileRequest';
import { File } from '../../../Portfolio/Files/Domain/File';

describe('UploadFile Use Case', () => {
  it('should coordinate saving the physical file and its metadata using UploadFileRequest', async () => {
    // Arrange
    const storageMock = { save: jest.fn().mockResolvedValue(undefined) };
    const repositoryMock = { save: jest.fn().mockResolvedValue(undefined) };

    const useCase = new UploadFile(storageMock as any, repositoryMock as any);

    // Creamos una entidad de ejemplo para sacar los datos base
    const fileEntity = FileMother.create();
    const buffer = Buffer.from('fake-binary-data');

    // Creamos el Request (DTO) tal como lo definiste
    const request = new UploadFileRequest(
      fileEntity.name.name.getValue(), // Asumiendo que usas Value Objects (.value)
      fileEntity.size.getBytes(),
      fileEntity.type.type.getValue(),
      fileEntity.title.title.getValue(),
      fileEntity.alt.alt.getValue(),
      buffer,
    );

    // Act
    await useCase.execute(request);

    // Assert
    // 1. Verificamos que el storage recibió el buffer y el path (o nombre)
    expect(storageMock.save).toHaveBeenCalledWith(
      expect.any(String), // Aquí iría la lógica de construcción del path
      request.buffer,
    );

    // 2. Verificamos que el repositorio guardó la entidad
    // Nota: El Caso de Uso internamente debió convertir el DTO a Entidad o usar la recibida
    expect(repositoryMock.save).toHaveBeenCalledWith(expect.any(File));
  });
});