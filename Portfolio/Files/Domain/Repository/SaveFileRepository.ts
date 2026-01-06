import { File } from '../File';

export interface SaveFileRepository {
  save(file: File): Promise<void>;
}
