import { GetFileStorage } from '../Domain/Storage/GetFileStorage';
import { promises as fs } from 'node:fs';
import { join } from 'path';

export class NodeGetFile implements GetFileStorage {
  private readonly uploadBasePath = './uploads';
  async execute(fileName: string): Promise<string> {
    try {
      const folders = await fs.readdir(this.uploadBasePath);

      for (const folder of folders) {
        const folderPath = join(this.uploadBasePath, folder);
        const stat = await fs.stat(folderPath);

        if (stat.isDirectory()) {
          const filePath = join(folderPath, fileName);
          try {
            await fs.access(filePath);
            return filePath;
          } catch {
            continue;
          }
        }
      }

      return '';
    } catch {
      return '';
    }
  }
}
