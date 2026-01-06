import {
  Body,
  Controller,
  Inject,
  Post,
  UploadedFile,
  UseInterceptors,
} from '@nestjs/common';
import { UpdateUserImageRequest } from '../../../../Portfolio/User/Application/DTO/UpdateUserImageRequest';
import { FileInterceptor } from '@nestjs/platform-express';
import { UpdateUserImageService } from '../../services/update-user-image/update-user-image.service';

@Controller('user')
export class UpdateUserImageController {
  constructor( private service: UpdateUserImageService) {}

}
