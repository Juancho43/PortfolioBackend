import { promises as fs } from 'fs';
import { join, extname } from 'path';
import { v4 as uuid } from 'uuid';
import { SaveFileStorage } from '../Domain/Storage/SaveFileStorage';

export class NodeUploadFile implements SaveFileStorage {
  async uploadFile(file: Express.Multer.File): Promise<string> {
    try {
      // 1. Crear la ruta de la carpeta y asegurar que existe
      const uploadDir = join(__dirname, '../../uploads/');
      await fs.mkdir(uploadDir, { recursive: true });

      // 2. Sanitizar el nombre (ejemplo: usar un UUID + extensión original)
      const fileName = `${uuid()}${extname(file.originalname)}`;
      const filePath = join(uploadDir, fileName);

      // 3. Escribir el archivo
      await fs.writeFile(filePath, file.buffer);
      // 4. Retornar algo útil (la ruta relativa o el nombre)
      return fileName;
    } catch (error) {
      // eslint-disable-next-line @typescript-eslint/no-unsafe-member-access
      console.error('Error al subir archivo:', error.message);
      throw new Error('No se pudo guardar el archivo');
    }
  }
}
