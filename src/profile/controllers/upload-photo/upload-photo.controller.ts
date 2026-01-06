import {
  Body,
  Controller,
  Post,
  UploadedFile,
  UseInterceptors,
} from '@nestjs/common';
import { ApiBody, ApiConsumes, ApiTags } from '@nestjs/swagger';
import { UploadPhotoRequest } from '../../../../Portfolio/Profile/Application/DTO/UploadPhotoRequest';
import { FileInterceptor } from '@nestjs/platform-express';

@ApiTags('Profile')
@Controller('profile')
export class UploadPhotoController {
  @ApiBody({
    description: 'Upload CV with metadata and file',
    schema: {
      type: 'object',
      properties: {
        profileId: { type: 'string' },
        title: { type: 'string' },
        alt: { type: 'string' },
        file: { type: 'string', format: 'binary' },
      },
    },
  })
  @ApiConsumes('multipart/form-data')
  @UseInterceptors(FileInterceptor('file'))
  @Post('upload-photo')
  execute(
    @UploadedFile() file: Express.Multer.File,
    @Body() body: UploadPhotoRequest,
  ) {}
}
