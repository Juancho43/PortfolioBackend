import { Controller, Delete, Param } from '@nestjs/common';
import { ProjectsService } from '../../projects.service';
import { ApiResponse } from '../../../../Portfolio/Shared/Application/ApiResponse';
import { ProjectResponse } from '../../../../Portfolio/Projects/Application/DTO/ProjectResponse';
import { DeleteProjectRequest } from '../../../../Portfolio/Projects/Application/DTO/DeleteProjectRequest';

@Controller('project')
export class DeleteProjectController {
  constructor(private readonly service: ProjectsService) {}

  @Delete('delete/:id')
  async delete(@Param('id') id: string) {
    try {
      const result = await this.service.execute_delete(
        new DeleteProjectRequest(id),
      );
      // eslint-disable-next-line @typescript-eslint/no-unsafe-return
      return new ApiResponse().generate({
        data: new ProjectResponse().generate(result),
        code: 201,
        message: 'Project deleted successfully',
      });
    } catch (e) {
      return new ApiResponse().generateErrorResponse(e.toString());
    }
  }
}
