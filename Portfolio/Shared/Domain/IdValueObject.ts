
export class IdValueObject {
  private readonly value: string;

  private constructor(value: string) {
    this.value = value;
  }

  public static create(value: string): IdValueObject {
    return new IdValueObject(value);
  }

  public getValue(): string {
    return this.value;
  }

  public equals(other: IdValueObject): boolean {
    return this.value === other.value;
  }
}
