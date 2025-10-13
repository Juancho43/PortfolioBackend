import { Test, TestingModule } from '@nestjs/testing';
import { GetPinnedProjectsController } from './get-pinned-projects.controller';

describe('GetPinnedProjectsController', () => {
  let controller: GetPinnedProjectsController;

  beforeEach(async () => {
    const module: TestingModule = await Test.createTestingModule({
      controllers: [GetPinnedProjectsController],
    }).compile();

    controller = module.get<GetPinnedProjectsController>(GetPinnedProjectsController);
  });

  it('should be defined', () => {
    expect(controller).toBeDefined();
  });
});
