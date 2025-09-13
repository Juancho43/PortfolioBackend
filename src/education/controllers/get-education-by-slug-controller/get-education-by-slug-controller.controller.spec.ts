import { Test, TestingModule } from '@nestjs/testing';
import { GetEducationBySlugControllerController } from './get-education-by-slug-controller.controller';

describe('GetEducationBySlugControllerController', () => {
  let controller: GetEducationBySlugControllerController;

  beforeEach(async () => {
    const module: TestingModule = await Test.createTestingModule({
      controllers: [GetEducationBySlugControllerController],
    }).compile();

    controller = module.get<GetEducationBySlugControllerController>(GetEducationBySlugControllerController);
  });

  it('should be defined', () => {
    expect(controller).toBeDefined();
  });
});
