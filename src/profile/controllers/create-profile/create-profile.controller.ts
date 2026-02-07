import { Body, Controller, Inject, Post } from '@nestjs/common';
import { ApiBody, ApiTags } from '@nestjs/swagger';
import { CreateProfileService } from '../../services/create-profile/create-profile-service.service';
import { CreateProfileRequest } from '../../../../Portfolio/Profile/Application/DTO/CreateProfileRequest';
import { ProfileResponse } from '../../../../Portfolio/Profile/Application/DTO/ProfileResponse';
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
        bio: { type: 'string' },
        role: { type: 'string' },
        description: { type: 'string' },
      },
    },
  })
  @Post('create')
  async execute(@Body() body: CreateProfileRequest) {
    try {
      const result = await this.service.create(body);
      const response = new ProfileResponse();
      return response.generate(result)
    } catch (error) {
      return error;
    }
  }
}
