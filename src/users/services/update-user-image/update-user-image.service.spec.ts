import { Test, TestingModule } from '@nestjs/testing';
import { UpdateUserImageService } from './update-user-image.service';

describe('UpdateUserImageService', () => {
  let service: UpdateUserImageService;

  beforeEach(async () => {
    const module: TestingModule = await Test.createTestingModule({
      providers: [UpdateUserImageService],
    }).compile();

    service = module.get<UpdateUserImageService>(UpdateUserImageService);
  });

  it('should be defined', () => {
    expect(service).toBeDefined();
  });
});
