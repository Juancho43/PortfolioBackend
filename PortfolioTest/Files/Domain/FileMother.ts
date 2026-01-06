import { faker } from '@faker-js/faker';
import { File } from '../../../Portfolio/Files/Domain/File';
import { FileId } from '../../../Portfolio/Files/Domain/ValueObject/FileId';
import { FileName } from '../../../Portfolio/Files/Domain/ValueObject/FileName';
import { FileSize } from '../../../Portfolio/Files/Domain/ValueObject/FileSize';
import { FileType } from '../../../Portfolio/Files/Domain/ValueObject/FileType';
import { FilePath } from '../../../Portfolio/Files/Domain/ValueObject/FilePath';
import { FileTitle } from '../../../Portfolio/Files/Domain/ValueObject/FileTitle';
import { FileAlt } from '../../../Portfolio/Files/Domain/ValueObject/FileAlt';

export class FileMother {
  static create(
    overrides: Partial<{
      id: string;
      name: string;
      size: number;
      type: string;
      path: string;
      title: string;
      alt: string;
    }> = {},
  ): File {
    return File.create(
      FileId.create(overrides.id ?? faker.string.uuid()),
      FileName.create(overrides.name ?? faker.system.fileName()),
      FileSize.fromKilobytes(
        overrides.size ?? faker.number.int({ min: 1000, max: 5000000 }),
      ),
      FileType.create(overrides.type ?? faker.system.mimeType()),
      FilePath.create(
        overrides.path ?? `uploads/${faker.system.commonFileName()}`,
      ),
      FileTitle.create(overrides.title ?? faker.lorem.words(3)),
      FileAlt.create(overrides.alt ?? faker.lorem.sentence()),
    );
  }

  // Escenario común: Un PDF para el CV
  static createPDF(): File {
    return this.create({
      name: 'curriculum.pdf',
      type: 'application/pdf',
    });
  }

  // Escenario común: Una imagen
  static createImage(): File {
    return this.create({
      type: 'image/jpeg',
      path: `uploads/images/${faker.string.alphanumeric(10)}.jpg`,
    });
  }
}
