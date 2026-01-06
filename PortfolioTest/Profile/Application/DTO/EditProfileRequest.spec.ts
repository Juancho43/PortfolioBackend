import { CreateProfileRequest } from '../../../../Portfolio/Profile/Application/DTO/CreateProfileRequest';
import { EditProfileRequest } from '../../../../Portfolio/Profile/Application/DTO/EditProfileRequest';

describe('EditProfileRequest', () => {
  it('should create an instance with id and nested CreateProfileRequest data', () => {
    // 1. Preparación: Primero creamos el sub-objeto
    const profileId = 'user-123';
    const profileData = new CreateProfileRequest(
      'Jane Doe',
      'Senior Developer',
      'Expert in Hexagonal Architecture',
      'Clean coder',
    );

    // 2. Ejecución: Creamos el request de edición
    const editRequest = new EditProfileRequest(profileId, profileData);

    // 3. Aserciones
    expect(editRequest.id).toBe(profileId);
    expect(editRequest.data).toBeInstanceOf(CreateProfileRequest);
    expect(editRequest.data.name).toBe('Jane Doe');
    expect(editRequest.data).toEqual(profileData); // Verifica que los datos coincidan
  });

  it('should verify nested properties are correctly mapped', () => {
    const editRequest = new EditProfileRequest(
      'id-99',
      new CreateProfileRequest('A', 'B', 'C', 'D'),
    );

    expect(editRequest.data.role).toBe('B');
  });
});
