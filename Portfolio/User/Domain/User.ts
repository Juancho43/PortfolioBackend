import { UserId } from './ValueObject/UserId';
import { UserMail } from './ValueObject/UserMail';
import { UserPassword } from './ValueObject/UserPassword';
import { Timestamp } from '../../Shared/Domain/Timestamp';
import { SoftDelete } from '../../Shared/Domain/SoftDelete';

export class User {
  private readonly id: UserId;
  private readonly email: UserMail;
  private password: UserPassword;
  private timestamp: Timestamp;
  private softDelete: SoftDelete;

  private constructor(
    id: UserId,
    email: UserMail,
    password: UserPassword,
    timestamp: Timestamp,
    softDelete: SoftDelete,
  ) {
    this.id = id;
    this.email = email;
    this.password = password;
    this.timestamp = timestamp;
    this.softDelete = softDelete;
  }

  public static create(
    id: UserId,
    email: UserMail,
    password: UserPassword,
    timestamp: Timestamp,
    softDelete: SoftDelete,
  ): User {
    return new User(id, email, password, timestamp, softDelete);
  }
}
