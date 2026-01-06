import { Test, TestingModule } from '@nestjs/testing';
import { UpdateUserImageController } from './update-user-image.controller';

describe('UpdateUserImageController', () => {
  let controller: UpdateUserImageController;

  beforeEach(async () => {
    const module: TestingModule = await Test.createTestingModule({
      controllers: [UpdateUserImageController],
    }).compile();

    controller = module.get<UpdateUserImageController>(UpdateUserImageController);
  });

  it('should be defined', () => {
    expect(controller).toBeDefined();
  });
});
