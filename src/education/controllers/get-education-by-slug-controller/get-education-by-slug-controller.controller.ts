import { Controller, Get, Param } from '@nestjs/common';
import { EducationService } from '../../education-service/education-service.service';

@Controller('education')
export class GetEducationBySlugController {

  constructor(private readonly service: EducationService) {
  }
  @Get('by/:slug')
  findBySlug(@Param() slug: string){
    return this.service.execute_getBySlug(slug);
  }
}
