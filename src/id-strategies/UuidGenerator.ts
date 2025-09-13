import { Injectable } from '@nestjs/common';
import { IdGeneratorStrategy } from '../../Portfolio/Shared/Domain/IdGeneratorStrategy'
import { v4 as uuidv4 } from 'uuid';

@Injectable()
export class UuidGenerator implements IdGeneratorStrategy {
  generate(): string {
    return uuidv4();
  }
}