import { Test, TestingModule } from '@nestjs/testing';
import { UploadPhotoController } from './upload-photo.controller';

describe('UploadPhotoController', () => {
  let controller: UploadPhotoController;

  beforeEach(async () => {
    const module: TestingModule = await Test.createTestingModule({
      controllers: [UploadPhotoController],
    }).compile();

    controller = module.get<UploadPhotoController>(UploadPhotoController);
  });

  it('should be defined', () => {
    expect(controller).toBeDefined();
  });
});
