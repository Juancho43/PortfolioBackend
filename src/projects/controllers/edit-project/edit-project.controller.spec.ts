import { Test, TestingModule } from '@nestjs/testing';
import { EditProjectController } from './edit-project.controller';

describe('EditProjectController', () => {
  let controller: EditProjectController;

  beforeEach(async () => {
    const module: TestingModule = await Test.createTestingModule({
      controllers: [EditProjectController],
    }).compile();

    controller = module.get<EditProjectController>(EditProjectController);
  });

  it('should be defined', () => {
    expect(controller).toBeDefined();
  });
});
