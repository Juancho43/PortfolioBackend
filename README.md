# Portfolio Backend

Este es el backend del proyecto de portafolio, desarrollado con el framework Laravel. El objetivo de este proyecto es proporcionar una API robusta y segura para gestionar la información del portafolio, incluyendo perfiles, educación, proyectos, trabajos, etiquetas y enlaces.

## Tecnologías Utilizadas

- **PHP**: Versión 8.2
- **Laravel**: Versión 11.31
- **Laravel Sanctum**: Para la autenticación de usuarios
- **Laravel Tinker**: Para interactuar con la aplicación desde la línea de comandos
- **FakerPHP**: Para generar datos de prueba
- **Pest**: Para pruebas unitarias

## Instalación

1. Clona el repositorio:
    ```sh
    git clone https://github.com/tu-usuario/portfolio-backend.git
    ```

2. Navega al directorio del proyecto:
    ```sh
    cd portfolio-backend
    ```

3. Instala las dependencias de Composer:
    ```sh
    composer install
    ```

4. Copia el archivo `.env.example` a [.env](http://_vscodecontentref_/1) y configura tus variables de entorno:
    ```sh
    cp .env.example .env
    ```

5. Genera la clave de la aplicación:
    ```sh
    php artisan key:generate
    ```

6. Ejecuta las migraciones para crear las tablas en la base de datos:
    ```sh
    php artisan migrate
    ```

## Uso

El proyecto proporciona una serie de endpoints para gestionar la información del portafolio. Estos endpoints están organizados en rutas públicas y privadas. Las rutas privadas requieren autenticación mediante Laravel Sanctum.

### Rutas Públicas

- **Perfil**: `/api/v1/profile`
- **Educación**: `/api/v1/education`
- **Proyectos**: `/api/v1/project`
- **Trabajos**: `/api/v1/work`
- **Etiquetas**: `/api/v1/tag`
- **Enlaces**: `/api/v1/link`

### Rutas Privadas

- **Perfil**: `/api/v1/profile/private`
- **Educación**: `/api/v1/education/private`
- **Proyectos**: `/api/v1/project/private`
- **Trabajos**: `/api/v1/work/private`
- **Etiquetas**: `/api/v1/tag/private`
- **Enlaces**: `/api/v1/link/private`

## Contribución

¡Gracias por considerar contribuir a este proyecto! Por favor, revisa la guía de contribución en la documentación de Laravel.

## Licencia

Este proyecto está licenciado bajo la [licencia MIT](https://opensource.org/licenses/MIT).
