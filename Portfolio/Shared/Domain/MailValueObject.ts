export class MailValueObject {
  private readonly value: string;
  private static readonly regex = new RegExp(
    /^(([^<>()\\[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
  );

  private constructor(value: string) {
    this.value = value;
  }

  public static create(email: string): MailValueObject {
    if (!MailValueObject.isValid(email)) {
      throw new Error('Invalid email format');
    }
    return new MailValueObject(email);
  }

  public static isValid(email: string): boolean {
    return MailValueObject.regex.test(email);
  }

  public getValue(): string {
    return this.value;
  }

  public equals(other: MailValueObject): boolean {
    return this.value === other.value;
  }
}
