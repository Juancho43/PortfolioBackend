export class UserPassword {
  private readonly value: string;
  private static readonly MIN_LENGTH = 8;
  private static readonly MAX_LENGTH = 128;

  private constructor(value: string) {
    this.value = value;
  }

  public static create(password: string): UserPassword {
    if (!password) {
      throw new Error('Password cannot be empty.');
    }

    if (password.length < UserPassword.MIN_LENGTH) {
      throw new Error(
        `Password must be at least ${UserPassword.MIN_LENGTH} characters long.`,
      );
    }

    if (password.length > UserPassword.MAX_LENGTH) {
      throw new Error(
        `Password cannot be longer than ${UserPassword.MAX_LENGTH} characters.`,
      );
    }

    return new UserPassword(password);
  }

  public getValue(): string {
    return this.value;
  }

  public equals(other: UserPassword): boolean {
    return this.value === other.value;
  }
}
