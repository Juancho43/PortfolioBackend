import { Controller, Get, HttpStatus, Inject, Param } from '@nestjs/common';
import { ApiResponse, ApiTags } from '@nestjs/swagger';
import { GetProfileService } from 'src/profile/services/get-profile/get-profile.service';
@ApiTags('Profile')
@Controller('profile')
export class GetProfileController {
  constructor(
    @Inject()
    private getProfileService: GetProfileService,
  ) {}
  @ApiResponse({
    status: HttpStatus.OK,
    description: 'Profile retrieved successfully. ',
    schema: {
      type: 'object',
      properties: {
        id: {
          type: 'string',
          example: '1',
        },
        name: {
          type: 'string',
          example: 'Juan',
        },
        role: {
          type: 'string',
          example: 'Fullstack',
        },
        bio: {
          type: 'string',
          example: 'Bio',
        },
        description: {
          type: 'string',
          example: 'Lorem ipsum',
        },
      },
    },
  })
  @Get(':id')
  execute(@Param('id') id: string) {
    return this.getProfileService.get(id);
  }
}
