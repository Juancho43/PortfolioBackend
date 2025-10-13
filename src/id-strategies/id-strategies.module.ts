import { Module } from '@nestjs/common';
import { ID_GENERATOR_TOKEN } from './token';
import { UuidGenerator } from './UuidGenerator';

@Module({
  providers: [
    {
      provide: ID_GENERATOR_TOKEN,
      useClass: UuidGenerator,
    },
  ],
  exports: [ID_GENERATOR_TOKEN],
})
export class IdStrategiesModule {}
