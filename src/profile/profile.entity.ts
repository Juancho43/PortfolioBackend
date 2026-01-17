// src/users/user.entity.ts
import { Entity, PrimaryKey, Property } from '@mikro-orm/core';

@Entity()
export class ProfileEntity {
  @PrimaryKey()
  id!: string;

  @Property()
  name!: string;
  @Property()
  role!: string;
  @Property()
  description!: string;
  @Property()
  bio!: string;

  @Property({ onCreate: () => new Date() })
  createdAt = new Date();
  @Property({ onUpdate: () => new Date() })
  updatedAt = new Date();
  @Property()
  deletedAt = false;

  constructor() {}

}
