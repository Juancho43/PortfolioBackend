import { Test, TestingModule } from '@nestjs/testing';
import { CreateProjectController } from './create-project.controller';

describe('CreateProjectController', () => {
  let controller: CreateProjectController;

  beforeEach(async () => {
    const module: TestingModule = await Test.createTestingModule({
      controllers: [CreateProjectController],
    }).compile();

    controller = module.get<CreateProjectController>(CreateProjectController);
  });

  it('should be defined', () => {
    expect(controller).toBeDefined();
  });
});
