import { AddProfileLinks } from '../../../Portfolio/Profile/Application/AddProfileLinks';
import { ProfileMother } from '../Domain/ProfileMother';
import { LinkMother } from '../../Links/Domain/LinkMother';
import { AddLinksRequest } from '../../../Portfolio/Profile/Application/DTO/AddLinksRequest';
import { CreateLinkRequest } from '../../../Portfolio/Links/Application/DTO/CreateLinkRequest';

describe('AddProfileLinks Use Case', () => {
  let getProfileMock: any;
  let createLinkMock: any;
  let saveProfileRepositoryMock: any;
  let useCase: AddProfileLinks;

  beforeEach(() => {
    getProfileMock = { execute: jest.fn() };
    createLinkMock = { execute: jest.fn() };
    saveProfileRepositoryMock = { execute: jest.fn() };

    useCase = new AddProfileLinks(
      getProfileMock,
      createLinkMock,
      saveProfileRepositoryMock,
    );
  });

  it('should add multiple links to an existing profile', async () => {
    // Arrange
    const profile = ProfileMother.create();
    const link1 = LinkMother.create({ title: 'GitHub' });
    const link2 = LinkMother.create({ title: 'LinkedIn' });

    const request = new AddLinksRequest(profile.id.profileId.getValue(), [
      new CreateLinkRequest('GitHub', 'https://github.com'),
      new CreateLinkRequest('LinkedIn', 'https://linkedin.com'),
    ]);

    getProfileMock.execute.mockResolvedValue(profile);
    // Mockeamos las respuestas sucesivas para cada link del bucle
    createLinkMock.execute
      .mockResolvedValueOnce(link1)
      .mockResolvedValueOnce(link2);

    saveProfileRepositoryMock.execute.mockResolvedValue(undefined);

    // Act
    const result = await useCase.execute(request);

    // Assert
    expect(getProfileMock.execute).toHaveBeenCalledWith(request.profileId);
    expect(createLinkMock.execute).toHaveBeenCalledTimes(2);

    // Verificamos que el perfil ahora contenga los nuevos links
    expect(profile.links).toContain(link1);
    expect(profile.links).toContain(link2);

    expect(saveProfileRepositoryMock.execute).toHaveBeenCalledWith(profile);
    expect(result).toBe(profile);
  });

  it('should fail if the profile does not exist', async () => {
    // Arrange
    getProfileMock.execute.mockRejectedValue(new Error('Profile not found'));
    const request = new AddLinksRequest('invalid-id', []);

    // Act & Assert
    await expect(useCase.execute(request)).rejects.toThrow('Profile not found');
    expect(createLinkMock.execute).not.toHaveBeenCalled();
    expect(saveProfileRepositoryMock.execute).not.toHaveBeenCalled();
  });
});
