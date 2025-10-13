import { Test, TestingModule } from '@nestjs/testing';
import { CreateEducationController } from './create-education.controller';

describe('CreateEducationController', () => {
  let controller: CreateEducationController;

  beforeEach(async () => {
    const module: TestingModule = await Test.createTestingModule({
      controllers: [CreateEducationController],
    }).compile();

    controller = module.get<CreateEducationController>(
      CreateEducationController,
    );
  });

  it('should be defined', () => {
    expect(controller).toBeDefined();
  });
});
