import { Body, Controller, Get, Post } from '@nestjs/common';
import { CreateEducationRequest } from '../../../../Portfolio/Educations/Application/DTO/CreateEducationRequest';
import { EducationService } from '../../education-service/education-service.service';

@Controller('education')
export class CreateEducationController {
  constructor(private readonly service: EducationService) {}
  @Get('create')
  create(@Body() data: CreateEducationRequest) {
    return this.service.execute_create(data);
  }
}
