import { ImageId } from './ValueObject/ImageId';
import { ImageWidth } from './ValueObject/ImageWidth';
import { ImageHeight } from './ValueObject/ImageHeight';
import { File } from '../../Files/Domain/File';

export class Image {
  private id: ImageId;
  private file: File;
  private width: ImageWidth;
  private height: ImageHeight;
}
