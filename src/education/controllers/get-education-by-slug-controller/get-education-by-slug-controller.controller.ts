import { Controller, Get, Param } from '@nestjs/common';
import { EducationService } from '../../education-service/education-service.service';
import { ApiResponse } from '../../../../Portfolio/Shared/Application/ApiResponse';
import { EducationResponse } from '../../../../Portfolio/Educations/Application/DTO/EducationResponse';
import { ApiTags } from '@nestjs/swagger';

@ApiTags('Education')
@Controller('education')
export class GetEducationBySlugController {
  constructor(private readonly service: EducationService) {}
  @Get('get/slug/:slug')
  async findBySlug(@Param('slug') slug: string) {
    try {
      const response = await this.service.execute_getBySlug(slug);
      // eslint-disable-next-line @typescript-eslint/no-unsafe-return
      return new ApiResponse().generate({
        // eslint-disable-next-line @typescript-eslint/no-unsafe-assignment
        data: new EducationResponse().generate(response),
        code: 200,
        message: 'Education retrieved successfully',
      });
    } catch (e) {
      return new ApiResponse().generateErrorResponse(e.toString());
    }
  }
}
