import { DeleteImage } from '../../../Portfolio/Images/Application/DeleteImage';
import { ImageMother } from '../Domain/ImageMother';
import { DeleteImageRequest } from '../../../Portfolio/Images/Application/DTO/DeleteImageRequest';

describe('DeleteImage Use Case', () => {
  let getImageByIdMock: any;
  let deleteFileMock: any;
  let repositoryMock: any;
  let useCase: DeleteImage;

  beforeEach(() => {
    getImageByIdMock = { execute: jest.fn() };
    deleteFileMock = { execute: jest.fn() };
    repositoryMock = { save: jest.fn() };

    useCase = new DeleteImage(getImageByIdMock, deleteFileMock, repositoryMock);
  });

  it('should delete the physical file and mark the image as soft-deleted', async () => {
    // Arrange
    const image = ImageMother.create();
    const imageId = 'uuid-123';
    const fileId = image.file.id.fileId.getValue();
    const request = new DeleteImageRequest(imageId);

    getImageByIdMock.execute.mockResolvedValue(image);
    deleteFileMock.execute.mockResolvedValue(undefined);
    repositoryMock.save.mockResolvedValue(undefined);

    // Verificamos que inicialmente no esté borrada
    expect(image.softdeleted.getDeletedAt()).toBeNull();

    // Act
    await useCase.execute(request);

    // Assert
    // 1. Verificamos que buscó la imagen correcta
    expect(getImageByIdMock.execute).toHaveBeenCalledWith(imageId);

    // 2. Verificamos que orquestó la eliminación del archivo físico
    expect(deleteFileMock.execute).toHaveBeenCalledWith(fileId);

    // 3. Verificamos que la entidad mutó a estado borrado
    expect(image.softdeleted.getDeletedAt()).toBeInstanceOf(Date);

    // 4. Verificamos que se guardaron los cambios
    expect(repositoryMock.save).toHaveBeenCalledWith(image);
  });

  it('should stop execution if the image does not exist', async () => {
    // Arrange
    getImageByIdMock.execute.mockRejectedValue(new Error('Image not found'));
    const request = new DeleteImageRequest('invalid-id');

    // Act & Assert
    await expect(useCase.execute(request)).rejects.toThrow('Image not found');
    expect(deleteFileMock.execute).not.toHaveBeenCalled();
    expect(repositoryMock.save).not.toHaveBeenCalled();
  });
});
