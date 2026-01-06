import { Test, TestingModule } from '@nestjs/testing';
import { GetProfileService } from './get-profile.service';

describe('GetProfileServiceService', () => {
  let service: GetProfileService;

  beforeEach(async () => {
    const module: TestingModule = await Test.createTestingModule({
      providers: [GetProfileService],
    }).compile();

    service = module.get<GetProfileService>(GetProfileService);
  });

  it('should be defined', () => {
    expect(service).toBeDefined();
  });
});
