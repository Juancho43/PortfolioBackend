export class FileSize {
  private readonly bytes: number;

  private constructor(bytes: number) {
    this.bytes = Math.max(0, Math.round(bytes));
  }

  static fromBytes(bytes: number): FileSize {
    if (!Number.isFinite(bytes) || bytes < 0) throw new Error('Invalid bytes');
    return new FileSize(bytes);
  }

  static fromKilobytes(kb: number): FileSize {
    if (!Number.isFinite(kb) || kb < 0) throw new Error('Invalid kilobytes');
    return new FileSize(kb * 1024);
  }

  static fromMegabytes(mb: number): FileSize {
    if (!Number.isFinite(mb) || mb < 0) throw new Error('Invalid megabytes');
    return new FileSize(mb * 1024 * 1024);
  }

  static fromGigabytes(gb: number): FileSize {
    if (!Number.isFinite(gb) || gb < 0) throw new Error('Invalid gigabytes');
    return new FileSize(gb * 1024 * 1024 * 1024);
  }

  static parse(input: string): FileSize {
    const s = input.trim().toUpperCase();
    const m = s.match(/^([\d.]+)\s*(B|KB|MB|GB|TB)?$/);
    if (!m) throw new Error('Invalid size format');
    const value = parseFloat(m[1]);
    const unit = m[2] ?? 'B';
    switch (unit) {
      case 'B':
        return FileSize.fromBytes(value);
      case 'KB':
        return FileSize.fromKilobytes(value);
      case 'MB':
        return FileSize.fromMegabytes(value);
      case 'GB':
        return FileSize.fromGigabytes(value);
      case 'TB':
        return FileSize.fromGigabytes(value * 1024);
      default:
        throw new Error('Unsupported unit');
    }
  }

  getBytes(): number {
    return this.bytes;
  }

  toKilobytes(): number {
    return this.bytes / 1024;
  }

  toMegabytes(): number {
    return this.bytes / (1024 * 1024);
  }

  toGigabytes(): number {
    return this.bytes / (1024 * 1024 * 1024);
  }

  add(other: FileSize): FileSize {
    return FileSize.fromBytes(this.bytes + other.bytes);
  }

  subtract(other: FileSize): FileSize {
    const result = this.bytes - other.bytes;
    if (result < 0) throw new Error('Resulting size must be >= 0');
    return FileSize.fromBytes(result);
  }

  equals(other: FileSize): boolean {
    return this.bytes === other.bytes;
  }

  compareTo(other: FileSize): number {
    return this.bytes - other.bytes;
  }

  toString(): string {
    const b = this.bytes;
    if (b >= 1024 * 1024 * 1024) return `${this.toGigabytes().toFixed(2)} GB`;
    if (b >= 1024 * 1024) return `${this.toMegabytes().toFixed(2)} MB`;
    if (b >= 1024) return `${this.toKilobytes().toFixed(2)} KB`;
    return `${b} B`;
  }

  toJSON(): number {
    return this.bytes;
  }
}
