import { GetImageById } from '../../../Portfolio/Images/Application/GetImageById';
import { ImageMother } from '../Domain/ImageMother';

describe('GetImageById Use Case', () => {
  let repositoryMock: any;
  let useCase: GetImageById;

  beforeEach(() => {
    // Mock del repositorio con el método específico
    repositoryMock = { getImageById: jest.fn() };
    useCase = new GetImageById(repositoryMock);
  });

  it('should return an image when it exists in the repository', async () => {
    // Arrange
    const expectedImage = ImageMother.create({ id: 'existing-uuid' });
    repositoryMock.getImageById.mockResolvedValue(expectedImage);

    // Act
    const result = await useCase.execute('existing-uuid');

    // Assert
    expect(repositoryMock.getImageById).toHaveBeenCalledWith('existing-uuid');
    expect(result).toBe(expectedImage);
    expect(result.id.getValue()).toBe('existing-uuid');
  });

  it('should throw an "Image not found" error when the image does not exist', async () => {
    // Arrange
    repositoryMock.getImageById.mockResolvedValue(null);

    // Act & Assert
    await expect(useCase.execute('non-existent-id')).rejects.toThrow(
      'Image not found',
    );

    expect(repositoryMock.getImageById).toHaveBeenCalledWith('non-existent-id');
  });
});
