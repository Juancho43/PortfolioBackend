export class ImageId {
  constructor(private readonly value: string) {
    if (!value || value.length < 5) throw new Error('Invalid ImageId');
  }
  static create(value: string): ImageId {
    return new ImageId(value);
  }
  getValue(): string {
    return this.value;
  }
}
