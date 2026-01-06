import { GetProfileById } from '../../../Portfolio/Profile/Application/GetProfileById';
import { GetProfileRepository } from '../../../Portfolio/Profile/Domain/GetProfileRepository';
import { Profile } from '../../../Portfolio/Profile/Domain/Profile';

describe('GetProfileById', () => {
  let useCase: GetProfileById;
  let repository: jest.Mocked<GetProfileRepository>;

  beforeEach(() => {
    // 1. Creamos un Mock del repositorio
    repository = {
      getById: jest.fn(),
    } as any;

    useCase = new GetProfileById(repository);
  });

  it('should return a profile when it exists', async () => {
    // Arrange: Preparamos el mock para devolver un Perfil
    const mockProfile = { id: { profileId: '123' } } as unknown as Profile;
    repository.getById.mockResolvedValue(mockProfile);

    // Act
    const result = await useCase.execute('123');

    // Assert
    expect(result).toBe(mockProfile);
    expect(repository.getById).toHaveBeenCalledWith('123');
    expect(repository.getById).toHaveBeenCalledTimes(1);
  });

  it('should throw an error when the profile does not exist', async () => {
    // Arrange: El repo devuelve null o undefined
    repository.getById.mockResolvedValue(null as unknown as Profile);

    // Act & Assert
    await expect(useCase.execute('999')).rejects.toThrow('Profile not found');
    expect(repository.getById).toHaveBeenCalledWith('999');
  });
});
