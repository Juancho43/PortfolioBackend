import { Test, TestingModule } from '@nestjs/testing';
import { GetProjectBySlugController } from './get-project-by-slug.controller';

describe('GetProjectBySlugController', () => {
  let controller: GetProjectBySlugController;

  beforeEach(async () => {
    const module: TestingModule = await Test.createTestingModule({
      controllers: [GetProjectBySlugController],
    }).compile();

    controller = module.get<GetProjectBySlugController>(GetProjectBySlugController);
  });

  it('should be defined', () => {
    expect(controller).toBeDefined();
  });
});
