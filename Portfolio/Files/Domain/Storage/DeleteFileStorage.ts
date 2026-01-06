export interface DeleteFileStorage {
  execute(filePath: string): Promise<void>;
}
