import { Controller, Get, Param } from '@nestjs/common';
import { EducationService } from '../../education-service/education-service.service';
import { EducationResponseCollection } from '../../../../Portfolio/Educations/Application/DTO/EducationResponseCollection';

@Controller('education')
export class GetEducationController {
  constructor(private readonly service: EducationService) {}

  @Get('get/:page/:limit')
  async getEducations(
    @Param('page') page: string,
    @Param('limit') limit: string,
  ) {

    return (new EducationResponseCollection()).generate(
      await this.service.execute_getAll(page, limit),
    );
  }
}
