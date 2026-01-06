import { UploadCV } from '../../../Portfolio/Profile/Application/UploadCV';
import { ProfileMother } from '../Domain/ProfileMother';
import { FileMother } from '../../Files/Domain/FileMother';

describe('UploadCV Use Case', () => {
  let getProfileMock: any;
  let uploadFileMock: any;
  let saveProfileRepositoryMock: any;
  let useCase: UploadCV;

  beforeEach(() => {
    getProfileMock = { execute: jest.fn() };
    uploadFileMock = { execute: jest.fn() };
    saveProfileRepositoryMock = { execute: jest.fn() };

    useCase = new UploadCV(
      getProfileMock,
      uploadFileMock,
      saveProfileRepositoryMock,
    );
  });

  it('should upload a file and associate it as CV to the profile', async () => {
    // Arrange
    const profile = ProfileMother.create();
    const fileEntity = FileMother.create();
    const request = {
      profileId: profile.id.profileId.getValue(),
      file: { buffer: Buffer.from('pdf content'), name: 'cv.pdf' }, // Simulación de request
    };

    getProfileMock.execute.mockResolvedValue(profile);
    uploadFileMock.execute.mockResolvedValue(fileEntity);
    saveProfileRepositoryMock.execute.mockResolvedValue(undefined);

    // Act
    const result = await useCase.execute(request as any);

    // Assert
    // 1. Verificamos que obtuvo el perfil correcto
    expect(getProfileMock.execute).toHaveBeenCalledWith(request.profileId);

    // 2. Verificamos que llamó al caso de uso de subir archivo
    expect(uploadFileMock.execute).toHaveBeenCalledWith(request.file);

    // 3. Verificamos que el perfil ahora tiene el CV asignado
    expect(profile.cv).toBe(fileEntity);

    // 4. Verificamos que se guardó el perfil actualizado
    expect(saveProfileRepositoryMock.execute).toHaveBeenCalledWith(profile);

    // 5. El resultado debe ser la entidad File del CV
    expect(result).toBe(fileEntity);
  });

  it('should fail if the profile does not exist', async () => {
    // Arrange
    getProfileMock.execute.mockRejectedValue(new Error('Profile not found'));
    const request = { profileId: 'invalid-id', file: {} };

    // Act & Assert
    await expect(useCase.execute(request as any)).rejects.toThrow(
      'Profile not found',
    );
    expect(uploadFileMock.execute).not.toHaveBeenCalled();
    expect(saveProfileRepositoryMock.execute).not.toHaveBeenCalled();
  });
});
