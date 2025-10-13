import { Controller, Get, Param } from '@nestjs/common';
import { ProjectsService } from '../../projects.service';
import { ApiResponse } from '../../../../Portfolio/Shared/Application/ApiResponse';
import { ProjectResponseCollection } from '../../../../Portfolio/Projects/Application/DTO/ProjectResponseCollection';

@Controller('project')
export class GetProjectsController {
  constructor(private readonly service: ProjectsService) {
  }
  @Get('get/paginated/:page/:limit')
  async get(@Param('page') page: string, @Param('limit') limit: string) {
    try {
      const response = await this.service.execute_getAll(page, limit);
      // eslint-disable-next-line @typescript-eslint/no-unsafe-return
      return new ApiResponse().generate({
        data: new ProjectResponseCollection().generate(response),
        code: 200,
        message: 'Projects retrieved successfully',
      });
    } catch (e) {
      return new ApiResponse().generateErrorResponse(e.toString())
    }
  }
}
