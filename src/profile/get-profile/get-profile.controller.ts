import { Controller, Get } from '@nestjs/common';

@Controller('profile')
export class GetProfileController {
  @Get()
  execute() {
    return 'hola';
  }
}
