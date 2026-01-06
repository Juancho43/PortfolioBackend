import { File } from '../../../Portfolio/Files/Domain/File';
import { FileTitle } from '../../../Portfolio/Files/Domain/ValueObject/FileTitle';
import { FileId } from '../../../Portfolio/Files/Domain/ValueObject/FileId';
import { FileName } from '../../../Portfolio/Files/Domain/ValueObject/FileName';
import { FileSize } from '../../../Portfolio/Files/Domain/ValueObject/FileSize';
import { FileType } from '../../../Portfolio/Files/Domain/ValueObject/FileType';
import { FilePath } from '../../../Portfolio/Files/Domain/ValueObject/FilePath';
import { FileAlt } from '../../../Portfolio/Files/Domain/ValueObject/FileAlt';

describe('File Entity', () => {
  // Datos de ejemplo para los tests
  const validArgs = {
    id: FileId.create('550e8400-e29b-41d4-a716-446655440000'),
    name: FileName.create('vacaciones.jpg'),
    size: FileSize.fromBytes(1024),
    type: FileType.create('image/jpeg'),
    path: FilePath.create('/uploads/2023/vacaciones.jpg'),
    title: FileTitle.create('Mis Vacaciones'),
    alt: FileAlt.create('Foto en la playa'),
  };

  it('should create a new File instance via static create method', () => {
    const file = File.create(
      validArgs.id,
      validArgs.name,
      validArgs.size,
      validArgs.type,
      validArgs.path,
      validArgs.title,
      validArgs.alt,
    );

    expect(file).toBeInstanceOf(File);
    expect(file.id.fileId.getValue()).toBe(validArgs.id.fileId.getValue());
    expect(file.name.name.getValue()).toBe('vacaciones.jpg');
  });

  it('should allow updating metadata through setters', () => {
    const file = File.create(
      validArgs.id,
      validArgs.name,
      validArgs.size,
      validArgs.type,
      validArgs.path,
      validArgs.title,
      validArgs.alt,
    );

    const newTitle = FileTitle.create('Nuevo Titulo');
    const newAlt = FileAlt.create('Nueva descripcion alt');

    file.title = newTitle;
    file.alt = newAlt;

    expect(file.title.title.getValue()).toBe('Nuevo Titulo');
    expect(file.alt.alt.getValue()).toBe('Nueva descripcion alt');
  });

  it('should handle the optional buffer correctly', () => {
    const file = File.create(
      validArgs.id,
      validArgs.name,
      validArgs.size,
      validArgs.type,
      validArgs.path,
      validArgs.title,
      validArgs.alt,
    );

    const fakeBuffer = Buffer.from('hello world');

    // Al inicio debe ser undefined
    expect(file.buffer).toBeUndefined();

    // Seteamos el buffer
    file.buffer = fakeBuffer;
    expect(file.buffer).toBe(fakeBuffer);
    expect(file.buffer?.toString()).toBe('hello world');
  });

  it('should expose all properties via getters', () => {
    const file = File.create(
      validArgs.id,
      validArgs.name,
      validArgs.size,
      validArgs.type,
      validArgs.path,
      validArgs.title,
      validArgs.alt,
    );

    expect(file.id).toBe(validArgs.id);
    expect(file.size).toBe(validArgs.size);
    expect(file.type).toBe(validArgs.type);
    expect(file.path).toBe(validArgs.path);
  });
});
