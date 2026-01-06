import { Test, TestingModule } from '@nestjs/testing';
import { UploadCvService } from './upload-cv.service';

describe('UploadCvService', () => {
  let service: UploadCvService;

  beforeEach(async () => {
    const module: TestingModule = await Test.createTestingModule({
      providers: [UploadCvService],
    }).compile();

    service = module.get<UploadCvService>(UploadCvService);
  });

  it('should be defined', () => {
    expect(service).toBeDefined();
  });
});
