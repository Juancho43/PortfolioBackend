import { EditProfile } from '../../../Portfolio/Profile/Application/EditProfile';
import { CreateProfileRequest } from '../../../Portfolio/Profile/Application/DTO/CreateProfileRequest';
import { EditProfileRequest } from '../../../Portfolio/Profile/Application/DTO/EditProfileRequest';

describe('EditProfile', () => {
  let useCase: EditProfile;
  let getProfileUseCase: jest.Mocked<any>;
  let saveRepository: jest.Mocked<any>;

  beforeEach(() => {
    // Mockeamos el caso de uso de búsqueda
    getProfileUseCase = {
      execute: jest.fn(),
    };
    // Mockeamos el repositorio de guardado
    saveRepository = {
      execute: jest.fn(),
    };

    useCase = new EditProfile(getProfileUseCase, saveRepository);
  });

  it('should update profile details and call save repository', async () => {
    // 1. Arrange: Crear un perfil existente "viejo"
    const existingProfile = {
      id: { profileId: '123' },
      name: { name: 'Old Name' },
      timestamp: { touch: jest.fn().mockReturnThis() }, // Simulamos el método touch
    } as any;

    getProfileUseCase.execute.mockResolvedValue(existingProfile);

    const editData = new CreateProfileRequest(
      'New Name',
      'New Role',
      'New Desc',
      'New Bio',
    );
    const request = new EditProfileRequest('123', editData);

    // 2. Act
    const result = await useCase.execute(request);

    // 3. Assert
    // Verificar que buscó el perfil correcto
    expect(getProfileUseCase.execute).toHaveBeenCalledWith('123');

    // Verificar que los datos se actualizaron en el objeto
    expect(result.name.name.getValue()).toBe('New Name');

    // Verificar que se llamó al método touch() para actualizar la fecha
    expect(existingProfile.timestamp.touch).toHaveBeenCalled();

    // Verificar que se persistió el cambio
    expect(saveRepository.execute).toHaveBeenCalledWith(existingProfile);
    expect(result).toBe(existingProfile);
  });

  it('should bubble up error if profile is not found', async () => {
    // Arrange: Simular que el buscador lanza el error que definimos antes
    getProfileUseCase.execute.mockRejectedValue(new Error('Profile not found'));

    const request = new EditProfileRequest('999', {} as any);

    // Act & Assert
    await expect(useCase.execute(request)).rejects.toThrow('Profile not found');
    expect(saveRepository.execute).not.toHaveBeenCalled();
  });
});
