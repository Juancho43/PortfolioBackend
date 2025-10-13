import { Controller, Get } from '@nestjs/common';
import { ProjectsService } from '../../projects.service';
import { ApiResponse } from '../../../../Portfolio/Shared/Application/ApiResponse';
import { ProjectResponseCollection } from '../../../../Portfolio/Projects/Application/DTO/ProjectResponseCollection';

@Controller('project')
export class GetPinnedProjectsController {
  constructor(private readonly projectService: ProjectsService) {
  }
  @Get('get/pinned')
  async getPinnedProjects() {
    try {
      const projects = await this.projectService.execute_getPinnedProjects();
      // eslint-disable-next-line @typescript-eslint/no-unsafe-return
      return new ApiResponse().generate({
        // eslint-disable-next-line @typescript-eslint/no-unsafe-assignment
        data: new ProjectResponseCollection().generate(projects),
        message: 'Pinned projects retrieved successfully',
        code: 200,
      });
    } catch (error) {
      // eslint-disable-next-line @typescript-eslint/no-unsafe-return,
      return new ApiResponse().generateErrorResponse(error.toString());
    }
  }
}
