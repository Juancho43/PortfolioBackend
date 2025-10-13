import { Test, TestingModule } from '@nestjs/testing';
import { GetProjectsController } from './get-projects.controller';

describe('GetProjectsController', () => {
  let controller: GetProjectsController;

  beforeEach(async () => {
    const module: TestingModule = await Test.createTestingModule({
      controllers: [GetProjectsController],
    }).compile();

    controller = module.get<GetProjectsController>(GetProjectsController);
  });

  it('should be defined', () => {
    expect(controller).toBeDefined();
  });
});
