export class ImageHeight {
  constructor(private readonly value: number) {
    if (value <= 0) throw new Error('Height must be positive');
  }
  static create(value: number): ImageHeight {
    return new ImageHeight(value);
  }
  getValue(): number {
    return this.value;
  }
}
