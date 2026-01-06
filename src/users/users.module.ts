import { Module } from '@nestjs/common';
import { UpdateUserImageController } from './controllers/update-user-image/update-user-image.controller';
import { UpdateUserImageService } from './services/update-user-image/update-user-image.service';

@Module({
  controllers: [UpdateUserImageController],
  providers: [UpdateUserImageService],
})
export class UsersModule {}
