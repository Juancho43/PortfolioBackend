export class Timestamp {
  private readonly createdAt: Date;
  private readonly updatedAt: Date;

  private constructor(createdAt: Date, updatedAt: Date) {
    this.createdAt = createdAt;
    this.updatedAt = updatedAt;
  }

  /**
   * Creates a new Timestamp object with both createdAt and updatedAt set to the current time.
   */
  public static now(): Timestamp {
    const now = new Date();
    return new Timestamp(now, now);
  }

  /**
   * Creates a Timestamp object from existing Date objects, typically for rehydrating from a database.
   * @param createdAt The creation date.
   * @param updatedAt The last update date.
   */
  public static fromDates(createdAt: Date, updatedAt: Date): Timestamp {
    // You can add validation here if needed, for example:
    // if (createdAt > updatedAt) {
    //   throw new Error("createdAt cannot be after updatedAt.");
    // }
    return new Timestamp(createdAt, updatedAt);
  }

  /**
   * Returns a new Timestamp object with the updatedAt field set to the current time.
   */
  public touch(): Timestamp {
    return new Timestamp(this.createdAt, new Date());
  }

  public getCreatedAt(): Date {
    return this.createdAt;
  }

  public getUpdatedAt(): Date {
    return this.updatedAt;
  }
}