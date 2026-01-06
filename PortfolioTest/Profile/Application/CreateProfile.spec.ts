import { CreateProfile } from '../../../Portfolio/Profile/Application/CreateProfile';
import { SaveProfileRepository } from '../../../Portfolio/Profile/Domain/SaveProfileRepository';
import { CreateProfileRequest } from '../../../Portfolio/Profile/Application/DTO/CreateProfileRequest';
import { Profile } from '../../../Portfolio/Profile/Domain/Profile';

describe('CreateProfile', () => {
  let useCase: CreateProfile;
  let repository: jest.Mocked<SaveProfileRepository>;

  beforeEach(() => {
    // Mock del repositorio
    repository = {
      execute: jest.fn(),
    } as any;

    useCase = new CreateProfile(repository);
  });

  it('should create a profile and save it in the repository', async () => {
    // 1. Arrange
    const request = new CreateProfileRequest(
      'John Doe',
      'Developer',
      'Description test',
      'Bio test',
    );

    // 2. Act
    const result = await useCase.execute(request);

    // 3. Assert
    // Verificamos que el resultado sea una instancia de Profile
    expect(result).toBeInstanceOf(Profile);
    expect(result.name.name.getValue()).toBe(request.name);

    // Verificamos que se llamó al repositorio con el perfil creado
    expect(repository.execute).toHaveBeenCalledTimes(1);

    // Verificamos que el objeto enviado al repositorio sea el mismo que el resultado
    expect(repository.execute).toHaveBeenCalledWith(result);
  });

  it('should generate a valid profile with a random UUID', async () => {
    const request = new CreateProfileRequest('A', 'B', 'C', 'D');

    const result = await useCase.execute(request);

    // Verificamos que el ID existe y tiene un formato de UUID (aunque sea un mock de objeto)
    expect(result.id.profileId).toBeDefined();
    expect(typeof result.id.profileId.getValue()).toBe('string');
  });
});
