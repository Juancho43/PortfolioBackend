import { UserRepository } from '../Domain/UserRepository';
import { User } from '../Domain/User';
import { IdGeneratorStrategy } from '../../Shared/Domain/IdGeneratorStrategy';
import { UserMail } from '../Domain/ValueObject/UserMail';
import { UserPassword } from '../Domain/ValueObject/UserPassword';
import { Timestamp } from '../../Shared/Domain/Timestamp';
import { SoftDelete } from '../../Shared/Domain/SoftDelete';
import { UserId } from '../Domain/ValueObject/UserId';

export class CreateUser {
  private repository: UserRepository;
  private idStrategy: IdGeneratorStrategy;

  constructor(repository: UserRepository, idGenerator: IdGeneratorStrategy) {
    this.repository = repository;
    this.idStrategy = idGenerator;
  }

  execute(mail: string, password: string): User {
    try {
      const user = User.create(
        UserId.create(this.idStrategy.generate()),
        UserMail.create(mail),
        UserPassword.create(password),
        Timestamp.now(),
        SoftDelete.no(),
      );
      this.repository.save(user);
      return user;
    } catch (error) {
      throw new Error(`Error creando el usuario: ${error}`);
    }
  }
}
