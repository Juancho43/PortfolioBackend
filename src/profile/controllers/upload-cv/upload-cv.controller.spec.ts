import { Test, TestingModule } from '@nestjs/testing';
import { UploadCvController } from './upload-cv.controller';

describe('UploadCvController', () => {
  let controller: UploadCvController;

  beforeEach(async () => {
    const module: TestingModule = await Test.createTestingModule({
      controllers: [UploadCvController],
    }).compile();

    controller = module.get<UploadCvController>(UploadCvController);
  });

  it('should be defined', () => {
    expect(controller).toBeDefined();
  });
});
