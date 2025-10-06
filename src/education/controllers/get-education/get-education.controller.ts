import { Controller, Get, Param } from '@nestjs/common';
import { EducationService } from '../../education-service/education-service.service';
import { EducationResponseCollection } from '../../../../Portfolio/Educations/Application/DTO/EducationResponseCollection';
import { ApiResponse } from '../../../../Portfolio/Shared/Application/ApiResponse';

@Controller('education')
export class GetEducationController {
  constructor(private readonly service: EducationService) {}

  @Get('get/:page/:limit')
  async getEducations(
    @Param('page') page: string,
    @Param('limit') limit: string,
  ) {
    try {
      const response = await this.service.execute_getAll(page, limit);
      // eslint-disable-next-line @typescript-eslint/no-unsafe-return
      return new ApiResponse().generate({
        data: new EducationResponseCollection().generate(response),
        code: 200,
        message: 'Education retrieved successfully',
      });
    } catch (e) {
      return new ApiResponse().generate({
        data: null,
        code: 400,
        message: e.toString(),
      });
    }
  }
}
