import { Test, TestingModule } from '@nestjs/testing';
import { DeleteProjectController } from './delete-project.controller';

describe('DeleteProjectController', () => {
  let controller: DeleteProjectController;

  beforeEach(async () => {
    const module: TestingModule = await Test.createTestingModule({
      controllers: [DeleteProjectController],
    }).compile();

    controller = module.get<DeleteProjectController>(DeleteProjectController);
  });

  it('should be defined', () => {
    expect(controller).toBeDefined();
  });
});
