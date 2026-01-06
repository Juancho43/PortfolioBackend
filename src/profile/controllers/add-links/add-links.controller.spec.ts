import { Test, TestingModule } from '@nestjs/testing';
import { AddLinksController } from './add-links.controller';

describe('AddLinksController', () => {
  let controller: AddLinksController;

  beforeEach(async () => {
    const module: TestingModule = await Test.createTestingModule({
      controllers: [AddLinksController],
    }).compile();

    controller = module.get<AddLinksController>(AddLinksController);
  });

  it('should be defined', () => {
    expect(controller).toBeDefined();
  });
});
