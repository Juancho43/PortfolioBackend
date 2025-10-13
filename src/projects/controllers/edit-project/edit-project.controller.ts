import { Body, Controller, Put } from '@nestjs/common';
import { ProjectsService } from '../../projects.service';
import { ApiResponse } from '../../../../Portfolio/Shared/Application/ApiResponse';
import { EditProjectRequest } from '../../../../Portfolio/Projects/Application/DTO/EditProjectRequest';
import { ProjectResponse } from '../../../../Portfolio/Projects/Application/DTO/ProjectResponse';

@Controller('project')
export class EditProjectController {
  constructor(private readonly service: ProjectsService) {}
  @Put('edit')
  async update(@Body() data: EditProjectRequest) {
    try {
      const response = await this.service.execute_edit(data);
      // eslint-disable-next-line @typescript-eslint/no-unsafe-return
      return new ApiResponse().generate({
        data: new ProjectResponse().generate(response),
        code: 200,
        message: 'Project updated successfully',
      });
    } catch (e) {
      return new ApiResponse().generateErrorResponse(e.toString());
    }
  }
}
