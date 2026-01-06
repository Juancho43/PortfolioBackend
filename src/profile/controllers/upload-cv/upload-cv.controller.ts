import {
  Body,
  Controller,
  Inject,
  Post,
  UploadedFile,
  UseInterceptors,
} from '@nestjs/common';
import {
  ApiBody,
  ApiConsumes,
  ApiExtraModels,
  ApiTags,
  getSchemaPath,
} from '@nestjs/swagger';
import { UploadCvService } from '../../services/upload-cv/upload-cv.service';
import { UploadCvRequest } from '../../../../Portfolio/Profile/Application/DTO/UploadCvRequest';
import { FileInterceptor } from '@nestjs/platform-express';

@ApiTags('Profile')
@Controller('profile')
export class UploadCvController {
  constructor(
    @Inject()
    private uploadCvService: UploadCvService,
  ) {}
  @ApiBody({
    description: 'Upload CV with metadata and file',
    schema: {
      type: 'object',
      properties: {
        profileId: { type: 'string' },
        title: { type: 'string' },
        alt: { type: 'string' },
        file: {type: 'string', format:'binary' },
      },
    },
  })
  @ApiConsumes('multipart/form-data')
  @UseInterceptors(FileInterceptor('file'))
  @Post('upload-cv')
  async execute(
    @UploadedFile() file: Express.Multer.File,
    @Body() body: UploadCvRequest,
  ) {
    const request = new UploadCvRequest(
      body.profileId,
      body.title,
      body.alt,
      {
      name: file.originalname,
      size: file.size,
      type: file.mimetype,
      buffer: file.buffer,
    });
    console.log(request);
    // return await this.uploadCvService.execute(request);
  }
}
