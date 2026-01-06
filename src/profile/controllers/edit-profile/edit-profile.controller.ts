import { Body, Controller, Inject, Put } from '@nestjs/common';
import { ApiBody, ApiTags } from '@nestjs/swagger';
import { EditProfileRequest } from '../../../../Portfolio/Profile/Application/DTO/EditProfileRequest';
import { EditProfileService } from '../../services/edit-profile/edit-profile.service';

@ApiTags('Profile')
@Controller('profile')
export class EditProfileController {
  constructor(
    @Inject()
    private readonly service: EditProfileService,
  ) {}
  @ApiBody({
    schema: {
      type: 'object',
      properties: {
        id: { type: 'string' },
        data: {
          type: 'object',
          properties: {
            name: { type: 'string' },
            role: { type: 'string' },
            description: { type: 'string' },
          },
        },
      },
    },
  })
  @Put('edit')
  async editProfile(@Body() request: EditProfileRequest) {
    try {
      const result = await this.service.execute(request);
      return result;
    } catch (error) {
      return error;
    }
  }
}
