import { CreateLinkRequest } from '../../../../Portfolio/Links/Application/DTO/CreateLinkRequest';

describe('CreateLinkRequest DTO', () => {
  it('should create a request instance with correct values', () => {
    // Arrange
    const title = 'My Portfolio';
    const url = 'https://portfolio.com';

    // Act
    const request = new CreateLinkRequest(title, url);

    // Assert
    expect(request.title).toBe(title);
    expect(request.url).toBe(url);
  });

  it('should be an instance of CreateLinkRequest', () => {
    const request = new CreateLinkRequest('Title', 'https://url.com');
    expect(request).toBeInstanceOf(CreateLinkRequest);
  });
});
