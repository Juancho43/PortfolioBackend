import { MailValueObject } from 'Portfolio/Shared/Domain/MailValueObject';

export class UserMail {
  private value: MailValueObject;
  private constructor(value: MailValueObject) {
    this.value = value;
  }

  static create(mail: string): UserMail {
    return new UserMail(MailValueObject.create(mail));
  }
}
