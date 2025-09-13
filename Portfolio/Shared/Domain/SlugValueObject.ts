export class SlugValueObject {
  private readonly value: string;

  private constructor(value: string) {
    if (!SlugValueObject.isValid(value)) {
      throw new Error("Invalid slug format.");
    }
    this.value = value;
  }

  public static create(text: string): SlugValueObject {
    const value = SlugValueObject.slugify(text);
    return new SlugValueObject(value);
  }

  public getValue(): string {
    return this.value;
  }

  public equals(other: SlugValueObject): boolean {
    return this.value === other.value;
  }

  private static slugify(text: string): string {
    return text
      .toString()
      .normalize('NFD') // Decompose combined graphemes to their base characters
      .replace(/[\u0300-\u036f]/g, '') // Remove diacritics
      .toLowerCase()
      .trim()
      .replace(/\s+/g, '-') // Replace spaces with -
      .replace(/[^\w-]+/g, '') // Remove all non-word chars
      .replace(/--+/g, '-'); // Replace multiple - with single -
  }

  private static isValid(slug: string): boolean {
    // A simple validation to ensure the slug is not empty
    // and only contains lowercase letters, numbers, and hyphens.
    return /^[a-z0-9-]+$/.test(slug) && slug.length > 0;
  }
}