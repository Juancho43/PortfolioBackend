import { Inject, Injectable } from '@nestjs/common';
import { GetProfileById } from 'Portfolio/Profile/Application/GetProfileById';
import type { GetProfileRepository } from 'Portfolio/Profile/Domain/GetProfileRepository';

@Injectable()
export class GetProfileService {
  public readonly getProfile: GetProfileById;
  constructor(
    @Inject('GetProfileRepository')
    private readonly getProfileInterface: GetProfileRepository,
  ) {
    this.getProfile = new GetProfileById(this.getProfileInterface);
  }

  get(request: string) {
    return this.getProfile.execute(request);
  }
}
