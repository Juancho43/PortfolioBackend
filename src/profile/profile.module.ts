import { Module } from '@nestjs/common';
import { GetProfileController } from './controllers/get-profile/get-profile.controller';
import { CreateProfileController } from './controllers/create-profile/create-profile.controller';
import { CreateProfileService } from './services/create-profile/create-profile-service.service';
import { GetProfileService } from './services/get-profile/get-profile.service';
import { SQLiteSaveProfile } from './repository/SQLiteSaveProfile';
import { SQLiteGetProfile } from './repository/SQLiteGetProfile';
import { EditProfileController } from './controllers/edit-profile/edit-profile.controller';
import { UploadCvController } from './controllers/upload-cv/upload-cv.controller';
import { UploadPhotoController } from './controllers/upload-photo/upload-photo.controller';
import { AddLinksController } from './controllers/add-links/add-links.controller';
import { EditProfileService } from './services/edit-profile/edit-profile.service';
import { UploadCvService } from './services/upload-cv/upload-cv.service';
import { UploadPhotoService } from './services/upload-photo/upload-photo.service';
import { AddLinksService } from './services/add-links/add-links.service';

@Module({
  controllers: [
    GetProfileController,
    CreateProfileController,
    EditProfileController,
    UploadCvController,
    UploadPhotoController,
    AddLinksController,
  ],
  providers: [
    CreateProfileService,
    {
      provide: 'SaveProfileRepository',
      useClass: SQLiteSaveProfile,
    },
    GetProfileService,
    {
      provide: 'GetProfileRepository',
      useClass: SQLiteGetProfile,
    },
    EditProfileService,
    UploadCvService,
    UploadPhotoService,
    AddLinksService,
  ],
})
export class ProfileModule {}
