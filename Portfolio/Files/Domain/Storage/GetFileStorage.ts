export interface GetFileStorage {
  execute(fileName: string): Promise<string>;
}
