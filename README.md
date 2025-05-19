# Portfolio Backend

Este es el backend del proyecto de portafolio, desarrollado con el framework Laravel. 
El objetivo de este proyecto es proporcionar una API robusta y segura para gestionar la información del portafolio, 
incluyendo perfiles, educación, proyectos, trabajos, etiquetas y enlaces.

## Tecnologías Utilizadas

- **PHP**: Versión 8.2
- **Laravel**: Versión 11.31
- **Laravel Sanctum**: Para la autenticación de usuarios
- **Laravel Tinker**: Para interactuar con la aplicación desde la línea de comandos
- **FakerPHP**: Para generar datos de prueba


## Instalación

1. Clona el repositorio:
2. Navega al directorio del proyecto:
3. Instala las dependencias de Composer:
4. Crea el archivo .env y configura tus variables de entorno:
5. Genera la clave de la aplicación: php artisan key:generate
6. Crea la base de datos. 
7. Ejecuta las migraciones para crear las tablas en la base de datos. php artisan migrate

## Uso

El proyecto proporciona una serie de endpoints para gestionar la información del portafolio. 
Estos endpoints están organizados en rutas públicas y privadas. 
Las rutas privadas requieren autenticación mediante Laravel Sanctum.

## Licencia

Este proyecto está licenciado bajo la [licencia MIT](https://opensource.org/licenses/MIT).
