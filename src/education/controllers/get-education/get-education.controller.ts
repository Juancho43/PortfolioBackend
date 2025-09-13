
import { Controller, Get, Param } from '@nestjs/common';
import { EducationService } from '../../education-service/education-service.service';

@Controller('education')
export class GetEducationController {
  constructor(private readonly service: EducationService) {}

  @Get('get/:page/:limit')
   getEducations(
    @Param('page') page: string,
    @Param('limit') limit: string,
  ) {
    return this.service.execute_getAll(page, limit);
  }
}