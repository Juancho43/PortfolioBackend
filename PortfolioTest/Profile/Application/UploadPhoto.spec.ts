import { UploadPhoto } from '../../../Portfolio/Profile/Application/UploadPhoto';
import { ProfileMother } from '../Domain/ProfileMother';
import { ImageMother } from '../../Images/Domain/ImageMother';
import { UploadPhotoRequest } from '../../../Portfolio/Profile/Application/DTO/UploadPhotoRequest';

describe('UploadPhoto Use Case', () => {
  let getProfileMock: any;
  let uploadImageMock: any;
  let saveProfileRepositoryMock: any;
  let useCase: UploadPhoto;

  beforeEach(() => {
    getProfileMock = { execute: jest.fn() };
    uploadImageMock = { execute: jest.fn() };
    saveProfileRepositoryMock = { execute: jest.fn() };

    useCase = new UploadPhoto(
      getProfileMock,
      uploadImageMock,
      saveProfileRepositoryMock,
    );
  });

  it('should upload an image and associate it to the profile', async () => {
    // Arrange
    const profile = ProfileMother.create();
    const imageEntity = ImageMother.create(); // Entidad Image completa
    const request = new UploadPhotoRequest(profile.id.profileId.getValue(), {
      width: 800,
      height: 800,
      file: {} as any,
    });

    getProfileMock.execute.mockResolvedValue(profile);
    uploadImageMock.execute.mockResolvedValue(imageEntity);
    saveProfileRepositoryMock.execute.mockResolvedValue(undefined);

    // Act
    const result = await useCase.execute(request);

    // Assert
    // 1. Verificamos que se obtuvo el perfil por ID
    expect(getProfileMock.execute).toHaveBeenCalledWith(request.profileId);

    // 2. Verificamos que se llamó al caso de uso de subir imagen con los datos correctos
    expect(uploadImageMock.execute).toHaveBeenCalledWith(request.image);

    // 3. Verificamos que la entidad Profile fue actualizada internamente
    expect(profile.photo).toBe(imageEntity);

    // 4. Verificamos que se persistió el cambio en el repositorio de perfiles
    expect(saveProfileRepositoryMock.execute).toHaveBeenCalledWith(profile);

    // 5. Verificamos que el retorno es la entidad Image
    expect(result).toBe(imageEntity);
    expect(result.width.getValue()).toBe(imageEntity.width.getValue());
  });

  it('should propagate error if GetProfileById fails', async () => {
    // Arrange
    getProfileMock.execute.mockRejectedValue(new Error('Profile not found'));
    const request = new UploadPhotoRequest('invalid-id', {} as any);

    // Act & Assert
    await expect(useCase.execute(request)).rejects.toThrow('Profile not found');
    expect(uploadImageMock.execute).not.toHaveBeenCalled();
  });
});
