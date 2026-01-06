import { Image } from '../../../Portfolio/Images/Domain/Image';
import { ImageId } from '../../../Portfolio/Images/Domain/ValueObject/ImageId';
import { FileMother } from '../../Files/Domain/FileMother';
import { ImageWidth } from '../../../Portfolio/Images/Domain/ValueObject/ImageWidth';
import { ImageHeight } from '../../../Portfolio/Images/Domain/ValueObject/ImageHeight';
import { randomUUID } from 'node:crypto';
import { Timestamp } from '../../../Portfolio/Shared/Domain/Timestamp';
import { SoftDelete } from '../../../Portfolio/Shared/Domain/SoftDelete';
export class ImageMother {
  static create(overrides: Partial<any> = {}): Image {
    return Image.create(
      // Si recibes un string en overrides.id, lo envolvemos en ImageId.create()
      overrides.id instanceof ImageId
        ? overrides.id
        : ImageId.create(overrides.id ?? randomUUID()),

      overrides.file ?? FileMother.create(),

      // Lo mismo para width y height si sueles pasar números en el test
      overrides.width instanceof ImageWidth
        ? overrides.width
        : ImageWidth.create(overrides.width ?? 800),

      overrides.height instanceof ImageHeight
        ? overrides.height
        : ImageHeight.create(overrides.height ?? 600),

      overrides.timestamp ?? Timestamp.now(),
      overrides.softdeleted ?? SoftDelete.no(),
    );
  }
}
