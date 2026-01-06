import { CreateProfileRequest } from '../../../../Portfolio/Profile/Application/DTO/CreateProfileRequest';

describe('CreateProfileRequest', () => {
  it('should create a valid request instance with provided values', () => {
    // 1. Datos de prueba
    const profileData = {
      name: 'John Doe',
      role: 'Software Engineer',
      description: 'Expert in NestJS',
      bio: 'Loves clean architecture',
    };

    // 2. Ejecución
    const request = new CreateProfileRequest(
      profileData.name,
      profileData.role,
      profileData.description,
      profileData.bio,
    );

    // 3. Aserciones
    expect(request).toBeInstanceOf(CreateProfileRequest);
    expect(request.name).toBe(profileData.name);
    expect(request.role).toBe(profileData.role);
    expect(request.description).toBe(profileData.description);
    expect(request.bio).toBe(profileData.bio);
  });

  it('should be immutable (optional check)', () => {
    const request = new CreateProfileRequest('Name', 'Role', 'Desc', 'Bio');

    // Si quisieras asegurar que no se cambien las propiedades (si usaras readonly)
    // puedes intentar reasignar y verificar que TypeScript se queje o que el objeto no cambie
    expect(request.name).toBe('Name');
  });
});
