<p align="center">
  <h1 align="center">CARPOOL</h1>
</p>

<p align="center">
  <strong>Sistema de Movilidad Compartida para la Comunidad Universitaria</strong>
</p>

<p align="center">
<a href="https://laravel.com"><img src="https://img.shields.io/badge/Framework-Laravel-red" alt="Framework"></a>
<a href="https://php.net"><img src="https://img.shields.io/badge/Language-PHP-blue" alt="Language"></a>
<a href="https://mysql.com"><img src="https://img.shields.io/badge/Database-MySQL-orange" alt="Database"></a>
<a href="https://github.com/tu-usuario/CARPOOL/actions"><img src="https://img.shields.io/badge/Build-Passing-brightgreen" alt="Build Status"></a>
</p>

## Sobre CARPOOL

CARPOOL es una plataforma de software diseñada para optimizar el transporte dentro de la comunidad universitaria en Colima. El sistema permite conectar a conductores y pasajeros que comparten rutas comunes, resolviendo problemas críticos de movilidad y saturación de infraestructura.

La aplicación facilita tareas comunes del proceso de carpooling, tales como:

- **Autenticación Institucional:** Acceso seguro mediante correos verificados del dominio @colima.tecnm.mx.
- **Gestión de Rutas:** Motor de búsqueda para conectar puntos de origen y destino de manera eficiente.
- **Módulo de Vehículos:** Registro de unidades con control de capacidad y características del auto.
- **Sistema de Solicitudes:** Gestión de asientos y confirmación de pasajeros en tiempo real.
- **Módulo de Calificaciones:** Registro de reputación para garantizar la confianza entre usuarios.

## Arquitectura del Sistema

El proyecto sigue una arquitectura de tres capas para garantizar la seguridad y escalabilidad:

1. **Frontend PWA:** Interfaz multiplataforma que consume la API REST.
2. **Backend API:** Basado en Laravel, encargado de la lógica de negocio y validaciones.
3. **Persistencia:** Base de datos MySQL con consultas parametrizadas para prevenir inyecciones SQL.

## Stack Tecnológico

CARPOOL utiliza las herramientas estándar de la industria para el desarrollo web moderno:

- [Laravel Eloquent ORM](https://laravel.com/docs/eloquent) para la gestión de base de datos.
- [Motor de Rutas](https://laravel.com/docs/routing) para la comunicación entre cliente y servidor.
- [Sistema de Migraciones](https://laravel.com/docs/migrations) para el control de versiones de la base de datos.
- [PWA (Progressive Web App)](https://web.dev/progressive-web-apps/) para la experiencia de usuario móvil.

## Instalación

Para desplegar el proyecto en un entorno de desarrollo local, siga estos pasos:

1. **Clonación:**
   ```bash
   git clone [https://github.com/tu-usuario/CARPOOL.git](https://github.com/tu-usuario/CARPOOL.git)

2. **Dependencias:**
    ```bash
    composer install

3. **Entorno:**
   ```bash
    Configure su archivo .env con las credenciales de su servidor local (XAMPP).

5. **Base de Datos:**
   ```bash
    php artisan migrate

5. **Servidor:**
    ```bash
    php artisan serve

