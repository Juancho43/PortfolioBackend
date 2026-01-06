import { Controller, Get, Param } from '@nestjs/common';
import { ProjectsService } from '../../projects.service';
import { ProjectResponse } from '../../../../Portfolio/Projects/Application/DTO/ProjectResponse';
import { ApiResponse } from '../../../../Portfolio/Shared/Application/ApiResponse';
import { ApiTags } from '@nestjs/swagger';

@ApiTags('Project')
@Controller('project')
export class GetProjectBySlugController {
  constructor(private readonly service: ProjectsService) {}
  @Get('get/slug/:slug')
  async findBySlug(@Param('slug') slug: string) {
    try {
      const response = await this.service.execute_getBySlug(slug);
      // eslint-disable-next-line @typescript-eslint/no-unsafe-return
      return new ApiResponse().generate({
        data: new ProjectResponse().generate(response),
        code: 200,
        message: 'Project retrieved successfully',
      });
    } catch (e) {
      return new ApiResponse().generateErrorResponse(e.toString());
    }
  }
}
