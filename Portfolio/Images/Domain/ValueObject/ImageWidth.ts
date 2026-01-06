export class ImageWidth {
  constructor(private readonly value: number) {
    if (value <= 0) throw new Error('Width must be positive');
  }
  static create(value: number): ImageWidth {
    return new ImageWidth(value);
  }
  getValue(): number {
    return this.value;
  }
}
