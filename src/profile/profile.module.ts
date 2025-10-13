import { Module } from '@nestjs/common';
import { GetProfileController } from './get-profile/get-profile.controller';

@Module({
  controllers: [GetProfileController],
})
export class ProfileModule {}
