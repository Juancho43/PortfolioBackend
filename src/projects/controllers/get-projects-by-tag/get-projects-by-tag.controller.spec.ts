import { Test, TestingModule } from '@nestjs/testing';
import { GetProjectsByTagController } from './get-projects-by-tag.controller';

describe('GetProjectsByTagController', () => {
  let controller: GetProjectsByTagController;

  beforeEach(async () => {
    const module: TestingModule = await Test.createTestingModule({
      controllers: [GetProjectsByTagController],
    }).compile();

    controller = module.get<GetProjectsByTagController>(
      GetProjectsByTagController,
    );
  });

  it('should be defined', () => {
    expect(controller).toBeDefined();
  });
});
