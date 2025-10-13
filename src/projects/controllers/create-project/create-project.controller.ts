import { Body, Controller, Post } from '@nestjs/common';
import { ProjectsService } from '../../projects.service';
import { CreateProjectRequest } from '../../../../Portfolio/Projects/Application/DTO/CreateProjectRequest';
import { ApiResponse } from '../../../../Portfolio/Shared/Application/ApiResponse';
import { ProjectResponse } from '../../../../Portfolio/Projects/Application/DTO/ProjectResponse';

@Controller('project')
export class CreateProjectController {
  constructor(private readonly service: ProjectsService) {}
  @Post('create')
  createProject(@Body() request: CreateProjectRequest) {
    try {
      const response = this.service.execute_create(request);
      // eslint-disable-next-line @typescript-eslint/no-unsafe-return
      return new ApiResponse().generate({
        // eslint-disable-next-line @typescript-eslint/no-unsafe-assignment
        data: new ProjectResponse().generate(response),
        code: 201,
        message: 'Education created successfully',
      });
    } catch (e) {
      // eslint-disable-next-line @typescript-eslint/no-unsafe-return
      return new ApiResponse().generate({
        data: null,
        code: 400,
        message: e.toString(),
      });
    }
  }
}
