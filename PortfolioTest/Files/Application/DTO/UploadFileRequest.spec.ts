import { UploadFileRequest } from '../../../../Portfolio/Files/Application/DTO/UploadFileRequest';

describe('UploadFileRequest DTO', () => {
  it('should create an upload file request instance with all metadata and buffer', () => {
    // Arrange
    const fileData = {
      name: 'profile-picture.png',
      size: 1024 * 5, // 5KB
      type: 'image/png',
      title: 'Profile Picture',
      alt: 'User profile avatar',
      buffer: Buffer.from('fake-binary-data-content'),
    };

    // Act

    const request = new UploadFileRequest(
      fileData.name,
      fileData.size,
      fileData.type,
      fileData.title,
      fileData.alt,
      fileData.buffer,
    );

    // Assert
    expect(request.name).toBe(fileData.name);
    expect(request.size).toBe(fileData.size);
    expect(request.type).toBe(fileData.type);
    expect(request.title).toBe(fileData.title);
    expect(request.alt).toBe(fileData.alt);
    expect(request.buffer).toBeInstanceOf(Buffer);
    expect(request.buffer.toString()).toBe('fake-binary-data-content');
  });


});
