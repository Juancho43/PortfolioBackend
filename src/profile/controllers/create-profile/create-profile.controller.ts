import { Body, Controller, Inject, Post } from '@nestjs/common';
import { ApiBody, ApiTags } from '@nestjs/swagger';
import { CreateProfileService } from '../../services/create-profile/create-profile-service.service';
import { CreateProfileRequest } from '../../../../Portfolio/Profile/Application/DTO/CreateProfileRequest';
@ApiTags('Profile')
@Controller('profile')
export class CreateProfileController {
  constructor(
    @Inject()
    private readonly service: CreateProfileService,
  ) {}
  @ApiBody({
    schema: {
      type: 'object',
      properties: {
        name: { type: 'string' },
        role: { type: 'string' },
        description: { type: 'string' },
      },
    },
  })
  @Post('create')
  async execute(@Body() body: CreateProfileRequest) {
    try {
      const result = await this.service.create(body);
      return result;
    } catch (error) {
      return error;
    }
  }
}
