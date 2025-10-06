import { Test, TestingModule } from '@nestjs/testing';
import { EditEducationController } from './edit-education.controller';

describe('EditEducationController', () => {
  let controller: EditEducationController;

  beforeEach(async () => {
    const module: TestingModule = await Test.createTestingModule({
      controllers: [EditEducationController],
    }).compile();

    controller = module.get<EditEducationController>(EditEducationController);
  });

  it('should be defined', () => {
    expect(controller).toBeDefined();
  });
});
