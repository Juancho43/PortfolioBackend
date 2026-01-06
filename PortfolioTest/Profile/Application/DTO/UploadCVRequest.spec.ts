import { UploadFileRequest } from '../../../../Portfolio/Files/Application/DTO/UploadFileRequest';
import { UploadCvRequest } from '../../../../Portfolio/Profile/Application/DTO/UploadCvRequest';

describe('UploadCvRequest DTO', () => {
  it('should create an upload CV request instance with profileId and nested file data', () => {
    // 1. Arrange: Creamos el request del archivo primero
    const fileBuffer = Buffer.from('pdf-content-data');
    const fileRequest = new UploadFileRequest(
      'curriculum-vitae.pdf',
      1024 * 50, // 50KB
      'application/pdf',
      'CV - Juan Perez',
      'Currículum profesional en PDF',
      fileBuffer,
    );

    const profileId = 'profile-uuid-456';

    // 2. Act: Instanciamos el DTO de subida de CV
    const request = new UploadCvRequest(profileId, fileRequest);

    // 3. Assert: Validamos la integridad de los datos
    expect(request.profileId).toBe(profileId);
    expect(request.file).toBeInstanceOf(UploadFileRequest);
    expect(request.file.name).toBe('curriculum-vitae.pdf');
    expect(request.file.buffer).toBe(fileBuffer);
  });

  it('should maintain the reference of the file request object', () => {
    // Arrange
    const mockFileRequest = {} as UploadFileRequest;
    const profileId = 'any-id';

    // Act
    const request = new UploadCvRequest(profileId, mockFileRequest);

    // Assert
    expect(request.file).toBe(mockFileRequest);
  });
});
