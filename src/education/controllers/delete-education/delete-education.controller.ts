import { Controller, Delete, Param } from '@nestjs/common';
import { EducationService } from '../../education-service/education-service.service';
import { DeleteEducationRequest } from '../../../../Portfolio/Educations/Application/DTO/DeleteEducationRequest';
import { EducationResponse } from '../../../../Portfolio/Educations/Application/DTO/EducationResponse';
import { ApiResponse } from '../../../../Portfolio/Shared/Application/ApiResponse';

@Controller('education')
export class DeleteEducationController {
  constructor(private readonly service: EducationService) {}
  @Delete('delete/:id')
  async delete(@Param('id') id: string) {
    const result = await this.service.execute_delete(
      new DeleteEducationRequest(id),
    );
    // eslint-disable-next-line @typescript-eslint/no-unsafe-return
    return new ApiResponse().generate({
      // eslint-disable-next-line @typescript-eslint/no-unsafe-assignment
      data: new EducationResponse().generate(result),
      code: 201,
      message: 'Education deleted successfully',
    });
  }
}
