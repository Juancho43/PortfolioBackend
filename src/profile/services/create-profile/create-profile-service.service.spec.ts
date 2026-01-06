import { Test, TestingModule } from '@nestjs/testing';
import { CreateProfileService } from './create-profile-service.service';

describe('CreateProfileServiceService', () => {
  let service: CreateProfileService;

  beforeEach(async () => {
    const module: TestingModule = await Test.createTestingModule({
      providers: [CreateProfileService],
    }).compile();

    service = module.get<CreateProfileService>(CreateProfileService);
  });

  it('should be defined', () => {
    expect(service).toBeDefined();
  });
});
