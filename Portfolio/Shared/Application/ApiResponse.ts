import { IResponse } from './IResponse';
import { ApiResponseInterface } from './ApiResponseInterface';

export class ApiResponse implements IResponse<ApiResponseInterface> {
  generate(data: ApiResponseInterface): any {
    return {
      status: data.code,
      message: data.message,
      data: data.data,
    };
  }
}
