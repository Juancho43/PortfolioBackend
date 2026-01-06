import { Body, Controller, Put } from '@nestjs/common';
import { EditEducationRequest } from '../../../../Portfolio/Educations/Application/DTO/EditEducationRequest';
import { EducationService } from '../../education-service/education-service.service';
import { EducationResponse } from '../../../../Portfolio/Educations/Application/DTO/EducationResponse';
import { ApiResponse } from '../../../../Portfolio/Shared/Application/ApiResponse';
import { ApiTags } from '@nestjs/swagger';

@ApiTags('Education')
@Controller('education')
export class EditEducationController {
  constructor(private readonly service: EducationService) {}
  @Put('edit')
  async update(@Body() data: EditEducationRequest) {
    try {
      const response = await this.service.execute_update(data);
      // eslint-disable-next-line @typescript-eslint/no-unsafe-return
      return new ApiResponse().generate({
        // eslint-disable-next-line @typescript-eslint/no-unsafe-assignment
        data: new EducationResponse().generate(response),
        code: 200,
        message: 'Education updated successfully',
      });
    } catch (e) {
      return new ApiResponse().generateErrorResponse(e.toString());
    }
  }
}
