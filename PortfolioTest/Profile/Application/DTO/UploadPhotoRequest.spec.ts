import { UploadFileRequest } from '../../../../Portfolio/Files/Application/DTO/UploadFileRequest';
import { UploadImageRequest } from '../../../../Portfolio/Images/Application/DTO/UploadImageRequest';
import { UploadPhotoRequest } from '../../../../Portfolio/Profile/Application/DTO/UploadPhotoRequest';

describe('UploadPhotoRequest DTO', () => {
  it('should create an upload photo request instance with profileId and nested image data', () => {
    // 1. Arrange: Construimos la jerarquía desde la base (File -> Image -> Photo)
    const fileRequest = new UploadFileRequest(
      'avatar.jpg',
      512,
      'image/jpeg',
      'Foto de Perfil',
      'Avatar del usuario',
      Buffer.from('binary-data'),
    );

    const imageRequest = new UploadImageRequest(400, 400, fileRequest);
    const profileId = 'user-123-uuid';

    // 2. Act
    const request = new UploadPhotoRequest(profileId, imageRequest);

    // Assert
    expect(request.profileId).toBe(profileId);
    expect(request.image).toBeInstanceOf(UploadImageRequest);
    expect(request.image.width).toBe(400);
    expect(request.image.file.name).toBe('avatar.jpg');
  });

  it('should maintain referential integrity of the nested image request', () => {
    // Arrange
    const mockImageRequest = {} as UploadImageRequest;
    const profileId = 'any-id';

    // Act
    const request = new UploadPhotoRequest(profileId, mockImageRequest);

    // Assert
    expect(request.image).toBe(mockImageRequest);
  });
});
