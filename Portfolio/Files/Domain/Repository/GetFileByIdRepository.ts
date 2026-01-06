import { File } from '../File';

export interface GetFileByIdRepository {
  getById(id: string): Promise<File>;
}
