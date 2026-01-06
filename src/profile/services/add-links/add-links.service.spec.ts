import { Test, TestingModule } from '@nestjs/testing';
import { AddLinksService } from './add-links.service';

describe('AddLinksService', () => {
  let service: AddLinksService;

  beforeEach(async () => {
    const module: TestingModule = await Test.createTestingModule({
      providers: [AddLinksService],
    }).compile();

    service = module.get<AddLinksService>(AddLinksService);
  });

  it('should be defined', () => {
    expect(service).toBeDefined();
  });
});
