import { Body, Controller, Get, Post } from '@nestjs/common';
import { CreateEducationRequest } from '../../../../Portfolio/Educations/Application/DTO/CreateEducationRequest';
import { EducationService } from '../../education-service/education-service.service';
import { EducationResponse } from '../../../../Portfolio/Educations/Application/DTO/EducationResponse';

@Controller('education')
export class CreateEducationController {
  constructor(private readonly service: EducationService) {}
  @Get('create')
  async create(@Body() data: CreateEducationRequest) {
    const response = await this.service.execute_create(data);
    return new EducationResponse().generate(response);
  }
}
