import { CreateLinkRequest } from '../../../../Portfolio/Links/Application/DTO/CreateLinkRequest';
import { AddLinksRequest } from '../../../../Portfolio/Profile/Application/DTO/AddLinksRequest';

describe('AddLinksRequest DTO', () => {
  it('should create an add links request instance with profileId and a list of link requests', () => {
    // 1. Arrange: Preparamos los links individuales
    const link1 = new CreateLinkRequest('GitHub', 'https://github.com/user');
    const link2 = new CreateLinkRequest(
      'LinkedIn',
      'https://linkedin.com/in/user',
    );
    const links = [link1, link2];
    const profileId = 'profile-uuid-789';

    // 2. Act
    const request = new AddLinksRequest(profileId, links);

    // 3. Assert
    expect(request.profileId).toBe(profileId);
    expect(request.links).toHaveLength(2);
    expect(request.links[0]).toBeInstanceOf(CreateLinkRequest);
    expect(request.links[0].title.toString()).toBe('GitHub');
    expect(request.links).toEqual(links);
  });

  it('should handle an empty list of links', () => {
    // Arrange
    const profileId = 'profile-uuid-empty';
    const links: CreateLinkRequest[] = [];

    // Act
    const request = new AddLinksRequest(profileId, links);

    // Assert
    expect(request.links).toEqual([]);
    expect(request.links.length).toBe(0);
  });
});
