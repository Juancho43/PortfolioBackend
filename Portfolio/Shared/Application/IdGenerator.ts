import { IdGeneratorStrategy } from '../Domain/IdGeneratorStrategy';

export class IdGenerator {
  private strategy: IdGeneratorStrategy;

  public generate(): string {
    return this.strategy.generate();
  }
}
