export class StringValueObject {
  private readonly value: string;

  private constructor(value: string) {
    this.value = StringValueObject.sanitize(value);
  }

  public static sanitize(value: string): string {
    // This regex removes common characters used in XSS and SQL injection.
    // It is NOT a complete solution and is provided for demonstration purposes.
    const sanitizedValue = value.replace(/[\<>\(\)\[\]\{\}\'\"\;%`]/g, '');

    return sanitizedValue.trim();
  }

  public static create(value: string) {
    return new StringValueObject(value);
  }

  public getValue(): string {
    return this.value;
  }

  public equals(other: StringValueObject): boolean {
    if (other === null || other === undefined) {
      return false;
    }
    return this.value === other.value;
  }
}
