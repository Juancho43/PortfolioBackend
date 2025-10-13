import { Body, Controller, Post } from '@nestjs/common';
import { CreateEducationRequest } from '../../../../Portfolio/Educations/Application/DTO/CreateEducationRequest';
import { EducationService } from '../../education-service/education-service.service';
import { EducationResponse } from '../../../../Portfolio/Educations/Application/DTO/EducationResponse';
import { ApiResponse } from '../../../../Portfolio/Shared/Application/ApiResponse';

@Controller('education')
export class CreateEducationController {
  constructor(private readonly service: EducationService) {}
  @Post('create')
  async create(@Body() request: CreateEducationRequest) {
    try {
      const response = await this.service.execute_create(request);
      // eslint-disable-next-line @typescript-eslint/no-unsafe-return
      return new ApiResponse().generate({
        // eslint-disable-next-line @typescript-eslint/no-unsafe-assignment
        data: new EducationResponse().generate(response),
        code: 201,
        message: 'Education created successfully',
      });
    } catch (e) {
      // eslint-disable-next-line @typescript-eslint/no-unsafe-return
      return new ApiResponse().generateErrorResponse(e.toString());
    }
  }
}
