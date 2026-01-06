import { UploadImage } from '../../../Portfolio/Images/Application/UploadImage';
import { FileMother } from '../../Files/Domain/FileMother';
import { Image } from '../../../Portfolio/Images/Domain/Image';1
describe('UploadImage Use Case', () => {
  let uploadFileMock: any;
  let saveImageRepositoryMock: any;
  let useCase: UploadImage;

  beforeEach(() => {
    // Mock del caso de uso de Files
    uploadFileMock = { execute: jest.fn() };
    // Mock del repositorio de Images
    saveImageRepositoryMock = { save: jest.fn().mockResolvedValue(undefined) };

    useCase = new UploadImage(uploadFileMock, saveImageRepositoryMock);
  });

  it('should upload a file and then create and save an image entity', async () => {
    // Arrange
    const fileEntity = FileMother.create();
    const request = {
      file: { buffer: Buffer.from('fake-image'), name: 'portrait.jpg' },
      width: 1920,
      height: 1080,
    };

    // Simulamos que la subida del archivo es exitosa y devuelve un File de dominio
    uploadFileMock.execute.mockResolvedValue(fileEntity);

    // Act
    const result = await useCase.execute(request as any);

    // Assert
    // 1. Verificamos que llamó al servicio de subida de archivos
    expect(uploadFileMock.execute).toHaveBeenCalledWith(request.file);

    // 2. Verificamos que el resultado es una instancia de Image
    expect(result).toBeInstanceOf(Image);

    // 3. Verificamos que la imagen tiene los datos del request y el archivo vinculado
    expect(result.file).toBe(fileEntity);
    expect(result.width.getValue()).toBe(1920);
    expect(result.height.getValue()).toBe(1080);
    expect(result.id.getValue()).toBeDefined();

    // 4. Verificamos que se persistió en el repositorio de imágenes
    expect(saveImageRepositoryMock.save).toHaveBeenCalledWith(result);
  });

  it('should fail if the file upload fails', async () => {
    // Arrange
    const request = { file: {}, width: 100, height: 100 };
    uploadFileMock.execute.mockRejectedValue(new Error('Upload failed'));

    // Act & Assert
    await expect(useCase.execute(request as any)).rejects.toThrow(
      'Upload failed',
    );
    expect(saveImageRepositoryMock.save).not.toHaveBeenCalled();
  });
});
