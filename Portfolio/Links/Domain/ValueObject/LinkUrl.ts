export class LinkUrl {
  private readonly url: string;

  private constructor(url: string) {
    if (!LinkUrl.isValidUrl(url)) {
      throw new Error('Invalid URL format');
    }
    this.url = url;
  }
  static create(url: string){
    return new LinkUrl(url);
  }
  public get value(): string {
    return this.url;
  }

  private static isValidUrl(url: string): boolean {
    const regex =
      /^(https?:\/\/)?([\w\-]+\.)+[\w\-]+(\/[\w\-._~:/?#[\]@!$&'()*+,;=]*)?$/i;
    return regex.test(url);
  }
}