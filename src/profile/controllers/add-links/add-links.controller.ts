import { Body, Controller, Put } from '@nestjs/common';
import { ApiTags } from '@nestjs/swagger';
import { AddLinksRequest } from '../../../../Portfolio/Profile/Application/DTO/AddLinksRequest';

@ApiTags('Profile')
@Controller('profile')
export class AddLinksController {

  @Put('add-links')
  execute(@Body() body: AddLinksRequest) {

  }
}
