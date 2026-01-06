import { join, extname } from 'path';
import { v4 as uuid } from 'uuid';
import { SaveFileStorage } from '../../Portfolio/Files/Domain/Storage/SaveFileStorage';
import * as fs from 'node:fs';
import { Error, Promise } from 'mongoose';

export class NodeUploadFile implements SaveFileStorage {
  async uploadFile(file: Express.Multer.File): Promise<string> {
    try {
      // 1. Crear la ruta de la carpeta y asegurar que existe
      const uploadDir = join(__dirname, '../../uploads/');

      // 2. Sanitizar el nombre (ejemplo: usar un UUID + extensión original)
      const fileName = `${uuid()}${extname(file.originalname)}`;
      const filePath = join(uploadDir, fileName);

      // 3. Escribir el archivo
      // 4. Retornar algo útil (la ruta relativa o el nombre)
      return fileName;
    } catch (error) {
      // eslint-disable-next-line @typescript-eslint/no-unsafe-member-access
      console.error('Error al subir archivo:', error.message);
      throw new Error('No se pudo guardar el archivo');
    }
  }

  save(path: string, content: Buffer): Promise<void> {
    return Promise.resolve(undefined);
  }
}
