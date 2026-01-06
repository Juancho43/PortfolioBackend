export interface SaveFileStorage {
  save(path: string, content: Buffer): Promise<void>;
}
