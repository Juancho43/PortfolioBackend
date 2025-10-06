import { Test, TestingModule } from '@nestjs/testing';
import { DeleteEducationController } from './delete-education.controller';

describe('DeleteEducationController', () => {
  let controller: DeleteEducationController;

  beforeEach(async () => {
    const module: TestingModule = await Test.createTestingModule({
      controllers: [DeleteEducationController],
    }).compile();

    controller = module.get<DeleteEducationController>(DeleteEducationController);
  });

  it('should be defined', () => {
    expect(controller).toBeDefined();
  });
});
