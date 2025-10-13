import { IResponse } from './IResponse';
import { ApiResponseInterface } from './ApiResponseInterface';

export class ApiResponse implements IResponse<ApiResponseInterface> {
  generate(data: ApiResponseInterface): any {
    return {
      success: true,
      status: data.code,
      message: data.message,
      data: data.data,
    };
  }
  generateErrorResponse(message: string, code = 500): any {
    return {
      success: false,
      status: code,
      message: message,
    };
  }
}
