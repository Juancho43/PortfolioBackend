export class Pinned {
  private value: boolean;

  private constructor(value: boolean) {
    this.value = value;
  }
  static create(value: boolean) {
    return new Pinned(value);
  }

  getValue(): boolean {
    return this.value;
  }
}