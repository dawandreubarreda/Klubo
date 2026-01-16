# Klubo

## 1. Nombre del Proyecto
**Klubo Gestión Deportiva**

## 2. Actividad Principal
Klubo es un sistema de gestión integral para clubes deportivos locales. Su objetivo es digitalizar y simplificar la administración de personas (jugadores, entrenadores, administradores, socios), equipos, categorías y asistencia a entrenamientos. Está pensado para pequeños y medianos clubes que necesitan una herramienta accesible, segura y fácil de usar para organizar su día a día y sus temporadas.

## 3. Diagrama de la base de datos (estructura actual)

> ✅ **Estado actual**: Base de datos funcional con tablas `users`, `roles` y relación muchos-a-muchos mediante `role_user`. Ya se puede visualizar la lista de roles en la ruta `/roles`.

### Tablas implementadas

#### `users`
| Campo         | Tipo     | Descripción                     |
|---------------|----------|---------------------------------|
| id            | BIGINT   | Clave primaria                  |
| dni           | STRING   | Documento de identidad (único)  |
| name          | STRING   | Nombre completo                 |
| email         | STRING   | Correo electrónico (único)      |
| password      | STRING   | Contraseña cifrada              |
| birth_date    | DATE     | Fecha de nacimiento             |
| address       | TEXT     | Dirección postal                |
| phone         | STRING   | Teléfono de contacto            |
| created_at    | TIMESTAMP| Fecha de creación               |
| updated_at    | TIMESTAMP| Fecha de última modificación    |

#### `roles`
| Campo         | Tipo     | Descripción                                  |
|---------------|----------|----------------------------------------------|
| id            | BIGINT   | Clave primaria                               |
| name          | STRING   | Nombre técnico (`admin`, `coach`, `player`, `fan`) |
| display_name  | STRING   | Nombre visible en la interfaz                |
| description   | TEXT     | Breve descripción del rol                    |
| created_at    | TIMESTAMP|                                              |
| updated_at    | TIMESTAMP|                                              |

#### `role_user` (tabla pivote)
| Campo    | Tipo    | Relación                          |
|----------|---------|-----------------------------------|
| user_id  | BIGINT  | → `users.id`                      |
| role_id  | BIGINT  | → `roles.id`                      |

### Relaciones
- Un usuario puede tener **uno o varios roles**.
- Un rol puede estar asignado a **múltiples usuarios**.
- Relación **muchos a muchos** gestionada mediante la tabla pivote `role_user`.

## 4. Funcionalidades implementadas
✅ **Listado de roles**:  
Se puede acceder a la ruta `/roles` para ver todos los roles disponibles en el sistema.

## 5. Instalación y configuración

### Requisitos
- PHP >= 8.0
- Composer
- MySQL (recomendado: XAMPP o LAMPP)
- Git

### Pasos para ejecutar el proyecto

1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/dawandreubarreda/Klubo.git
   cd Klubo
   composer install
   cp .env.example .env
   php artisan key:generate
   -Crear una base de datos en PhpMyAdmin llamada Klubo (utfmb8_unicode_ci)
   -Configurar la conexión en .env (Cada colaborador tiene que guardar este archivo en su equipo ya que      no se sube a Github)
       DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=klubo
        DB_USERNAME=root
        DB_PASSWORD=
   php artisan migrate
   php artisan db:seed --class=RoleSeeder
   php artisan serve
## 6. Vista creadas: 
   ### localhost:8000 
   ### localhost:8000/roles
    -se ha creado el archivo css y app.blade.php con header y footer para obtener un código más limpio
   
## 7. Próximas funcionalidades:
- Registro de nuevos usuarios con asignación de roles múltiples
- Autenticación (login/logout)
- Gestión de equipos y categorías
   
