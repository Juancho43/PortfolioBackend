import { Migrator } from '@mikro-orm/migrations';
import { defineConfig } from '@mikro-orm/core';
import { ProfileEntity } from './profile/profile.entity';
import { SqliteDriver } from '@mikro-orm/sqlite';

export default defineConfig({
  dbName: './src/portfolio.sqlite',
  driver: SqliteDriver,
  // 🔑 PASO CLAVE 1: Apuntar las Entidades al directorio compilado (JS)
  // Reemplaza esto con un path a los archivos JS compilados si estás en modo compilado.
  // En tu entorno, si usas 'entities: [GoalEntity, ProfileEntity]', MikroORM
  // intentará cargarlas. Si usas 'paths' debes apuntar a 'dist/entities/*.js'
  // o asegurarse de que las importaciones (como las que tienes) se resuelvan bien.
  entities: [ProfileEntity], // Si compilas a JS, esta importación TS podría ser problemática.

  // 🔑 RECOMENDACIÓN: Usa globs apuntando a los archivos JS compilados si los importas.
  // entities: ['./dist/entities/*.js'], // Esta es la práctica estándar en producción/compilado.

  allowGlobalContext: true,
  extensions: [Migrator],

  migrations: {
    // Si estás ejecutando con ts-node o en desarrollo:
    path: './src/migrations',
    pathTs: './src/migrations',
    glob: '!(*.d).{js,ts}', // Que busque tanto JS como TS
    transactional: true,
    disableForeignKeys: false,
  },
  debug: true,
});
