# Sistema de Autenticación PHP MVC

Un sistema de autenticación seguro desarrollado en PHP con arquitectura Model-View-Controller (MVC), featuring login y registro de usuarios con preparación para middlewares de seguridad avanzados.

##  Características

###  Implementado
- **Registro de usuarios** con validación completa
- **Sistema de login** seguro con verificación de credenciales
- **Arquitectura MVC** limpia y organizada
- **Sesiones seguras** con configuración robusta
- **Hashing de contraseñas** con bcrypt
- **Sistema de logging** para auditoría y debugging
- **Manejo de variables de entorno** con Dotenv
- **Manejo de errores** profesional
- **Prepared statements** contra inyección SQL

###  Próximamente
- Middlewares de autenticación
- Sistema de recuperación de contraseñas
- Verificación por email
- Roles y permisos de usuario
- Protección CSRF
- Rate limiting
- Autenticación de dos factores (2FA)

##  Stack Tecnológico

- **Backend:** PHP 8.0+
- **Base de Datos:** MySQL
- **Servidor:** XAMPP / Apache
- **Frontend:** HTML5, CSS3, JavaScript
- **Seguridad:** Password hashing, prepared statements
- **Configuración:** PHP Dotenv


##  Instalación Rápida

### Prerrequisitos
- XAMPP instalado y ejecutándose
- PHP 8.0+
- MySQL 5.7+
- Composer

### Paso a Paso

1. **Colocar proyecto en XAMPP**
C:\xampp\htdocs\My-app\


2. **Crear base de datos**
```
src/db estan las instrucciones SQL de definicion de datos
```
3. **Configurar entorno**
*Crear archivo .env*

```
DB_HOST=localhost
DB_USER=root
DB_PASS=
DB_NAME=my_app_db
ENVIRONMENT=development
```

4. **Instalar dependencias**

```
composer install
```

¡Listo! Accede a: http://localhost/My-app


# Seguridad

Medidas Implementadas
Contraseñas: Hashing con password_hash() y verificación con password_verify()

SQL: Prepared statements para prevenir inyecciones

Sesiones: Configuración segura con flags HTTP-only y SameSite

Validación: Sanitización de inputs del usuario

Logs: Sistema de logging sin exposición de datos sensibles

Entorno: Configuración sensible fuera del código

# Roadmap
Próximas Características
Sistema de Middlewares para protección de rutas

Recuperación de contraseñas vía email

Verificación de cuentas por correo electrónico

Roles de usuario y sistema de permisos

Panel de administración para gestión de usuarios

Mejoras Planificadas
API RESTful para frontend moderno

Suite de pruebas unitarias

Dockerización del proyecto

Internacionalización (i18n)

Sistema de plugins/módulos

## Contacto

- **Email**: lucasafigueroa93@gmail.com
- **Portafolio**: https://portafolio-five-xi-26.vercel.app/
- **Linkedin**: https://linkedin.com/in/lucas-a-figueroa
