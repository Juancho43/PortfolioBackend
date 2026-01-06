import { ProfileResponse } from '../../../../Portfolio/Profile/Application/DTO/ProfileResponse';

describe('ProfileResponse', () => {
  let profileResponse: ProfileResponse;

  beforeEach(() => {
    profileResponse = new ProfileResponse();
  });

  it('should map Profile domain entity to a plain response object', () => {
    // 1. Mock de la data (Simulando la estructura de tu Entidad de Dominio)
    const mockProfile: any = {
      id: { profileId: '123' },
      name: { name: 'John Doe' },
      rol: { role: 'Admin' },
      description: { description: 'Some description' },
      bio: { bio: 'Short bio' },
      timestamp: {
        getCreatedAt: () => new Date('2023-01-01'),
        getUpdatedAt: () => new Date('2023-01-02'),
      },
    };

    // 2. Ejecución
    const result = profileResponse.generate(mockProfile);

    // 3. Aserciones
    expect(result).toEqual({
      id: '123',
      name: 'John Doe',
      rol: 'Admin',
      description: 'Some description',
      bio: 'Short bio',
      createdAt: expect.any(Date),
      updatedAt: expect.any(Date),
    });

    expect(result.id).toBe(mockProfile.id.profileId);
  });
});
