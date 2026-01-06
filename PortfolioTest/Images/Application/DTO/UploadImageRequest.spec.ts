import { UploadImageRequest } from '../../../../Portfolio/Images/Application/DTO/UploadImageRequest';
import { UploadFileRequest } from '../../../../Portfolio/Files/Application/DTO/UploadFileRequest';

describe('UploadImageRequest DTO', () => {
  it('should create an upload image request instance with dimensions and nested file request', () => {
    // 1. Arrange: Preparamos los datos del archivo (File)
    const fileBuffer = Buffer.from('fake-image-content');
    const fileRequest = new UploadFileRequest(
      'logo-empresa.png',    // name
      2048,                  // size
      'image/png',           // type
      'Logo Principal',      // title
      'Logo de la empresa',  // alt
      fileBuffer             // buffer
    );

    // 2. Act: Creamos el request de Imagen usando el de Archivo
    const width = 800;
    const height = 600;
    const request = new UploadImageRequest(width, height, fileRequest);

    // 3. Assert: Validamos que la estructura sea la correcta
    expect(request.width).toBe(width);
    expect(request.height).toBe(height);

    // Validamos la composición
    expect(request.file).toBeInstanceOf(UploadFileRequest);
    expect(request.file.name).toBe('logo-empresa.png');
    expect(request.file.buffer).toEqual(fileBuffer);
  });

});