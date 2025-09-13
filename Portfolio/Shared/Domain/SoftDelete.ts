export class SoftDelete {
  private readonly isDeleted: boolean;
  private readonly deletedAt: Date | null;

  private constructor(isDeleted: boolean, deletedAt: Date | null) {
    this.isDeleted = isDeleted;
    this.deletedAt = deletedAt;
  }

  /**
   * Creates a new SoftDelete object indicating the entity is NOT deleted.
   */
  public static no(): SoftDelete {
    return new SoftDelete(false, null);
  }

  /**
   * Creates a new SoftDelete object indicating the entity IS deleted, with a timestamp.
   */
  public static yes(): SoftDelete {
    return new SoftDelete(true, new Date());
  }

  /**
   * Rehydrates a SoftDelete object from existing data (e.g., from a database).
   */
  public static from(isDeleted: boolean, deletedAt: Date | null): SoftDelete {
    if (isDeleted && deletedAt === null) {
      throw new Error('A deleted entity must have a deletedAt timestamp.');
    }
    if (!isDeleted && deletedAt !== null) {
      throw new Error('An undeleted entity cannot have a deletedAt timestamp.');
    }
    return new SoftDelete(isDeleted, deletedAt);
  }

  /**
   * Marks the entity as deleted. Returns a new instance.
   */
  public delete(): SoftDelete {
    return new SoftDelete(true, new Date());
  }

  /**
   * Marks the entity as undeleted. Returns a new instance.
   */
  public restore(): SoftDelete {
    return new SoftDelete(false, null);
  }

  public isSoftDeleted(): boolean {
    return this.isDeleted;
  }

  public getDeletedAt(): Date | null {
    return this.deletedAt;
  }
}
