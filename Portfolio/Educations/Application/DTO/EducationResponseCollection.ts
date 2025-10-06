import { EducationResponse } from './EducationResponse';
import { Education } from '../../Domain/Education';
import { IResponse } from '../../../Shared/Application/IResponse';

export class EducationResponseCollection implements IResponse<Education[]> {
  generate(data: Education[]) {
    if (!Array.isArray(data)) return [];
    return data.map((education) => new EducationResponse().generate(education));
  }
}
