# Klubo - Plataforma de Gestión Deportiva

**Klubo** es una plataforma web integral para la gestión de clubes deportivos, diseñada específicamente para organizaciones de pádel con equipos por categorías de edad. Simplifica la administración de usuarios, equipos, asistencias y comunicación entre miembros del club.

## Características Principales

- **Gestión multi-rol**: Administradores, entrenadores, jugadores y fans
- **Validación inteligente de equipos**: Control automático de edad, género y categorías
- **Sistema de asistencias tipo Excel**: Creación, seguimiento y estadísticas por jugador
- **Tablón de anuncios social**: Noticias del club con comentarios y sistema de likes
- **Filtro de contenido**: Bloqueo automático de lenguaje inapropiado en comentarios
- **Perfil personalizado**: Cada usuario puede gestionar sus datos personales

## 👥 Roles y Permisos

| Rol | Funcionalidades |
|-----|----------------|
| **Administrador** | Gestiona todos los usuarios, roles, temporadas, equipos y noticias |
| **Entrenador** | Administra sus equipos, añade jugadores elegibles y gestiona asistencias |
| **Jugador** | Consulta sus equipos, asistencias y estadísticas de participación |
| **Fan** | Visualiza noticias, comenta y da likes al contenido del club |

## 🚀 Requisitos del Sistema

- PHP 8.1 o superior
- MySQL 5.7 o superior
- Composer

  
## 💾 Instalación

Clona el repositorio y configura el proyecto:

```bash
git clone https://github.com/dawandreubarreda/Klubo.git
cd Klubo
```
1) Instalar dependencias de PHP con Composer


```bash
composer install
```
2) Copiar el archivo de entorno


```bash
cp .env.example .env
```
3) Configurar variables de entorno

Abre el archivo .env y ajusta la configuración de la base de datos:


```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tu_basededatos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```
4) Generar clave de aplicación de Laravel


```bash
php artisan key:generate
```
5) Ejecutar migraciones y seeders


```bash
php artisan migrate --seed
```
▶️ Ejecutar la aplicación


```bash
php artisan serve
```
Esto levantará el servidor en:
```bash
http://localhost:8000
```
![Diagrama](Diagrama_E-R.png)


