import { CreateProfileRequest } from './CreateProfileRequest';

export class EditProfileRequest {
  constructor(
    public readonly id: string,
    public readonly data: CreateProfileRequest,
  ) {}
}
