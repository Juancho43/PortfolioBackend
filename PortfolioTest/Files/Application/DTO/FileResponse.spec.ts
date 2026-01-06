import { FileMother } from '../../Domain/FileMother';
import { FileResponse } from '../../../../Portfolio/Files/Application/DTO/FileResponse';

describe('FileResponse', () => {
  it('should transform a File entity into a plain data object', () => {
    // Arrange
    const presenter = new FileResponse();
    const file = FileMother.create({
      id: '550e8400-e29b-41d4-a716-446655440000',
      name: 'documento.pdf',
      size: 2048,
      type: 'application/pdf',
      path: '/storage/docs/documento.pdf',
      title: 'Mi Documento',
      alt: 'Descripción del documento',
    });

    // Act
    const result = presenter.generate(file);

    // Assert
    expect(result).toEqual({
      id: '550e8400-e29b-41d4-a716-446655440000',
      name: 'documento.pdf',
      size: '2.00 MB',
      type: 'application/pdf',
      path: '/storage/docs/documento.pdf',
      title: 'Mi Documento',
      alt: 'Descripción del documento',
    });
  });

  it('should handle different file types correctly', () => {
    const presenter = new FileResponse();
    const file = FileMother.create({ type: 'image/png' });

    const result = presenter.generate(file);

    expect(result.type).toBe('image/png');
  });
});
