# 🌤️ Weather App — PHP MVC

Aplicación PHP que permite consultar el tiempo atmosférico de cualquier ciudad del mundo usando la API de OpenWeatherMap. Desplegada con Docker.
Por Guillermo Alvarez Franganillo ASIR-2

---

## Estructura del proyecto

```
.
├── .env                        # Variables de entorno (no subir al repo)
├── .gitignore
├── docker-compose.yml
├── config/
│   └── nginx-web.conf          # Configuración del servidor nginx
├── db/
│   └── init.sql                # Script de inicialización de la BD
├── web/
│   └── Dockerfile              # Imagen PHP-FPM con extensiones necesarias
└── src/                        # Raíz web servida por nginx
    ├── index.php
    ├── img/
    │   └── bg1.jpg
    ├── Controllers/
    │   ├── BuscarCiudadController.php
    │   ├── TiempoController.php
    │   └── ConsultasController.php
    ├── Models/
    │   ├── db_conexion.php
    │   ├── db_consultas.php
    │   ├── OpenWeatherService.php
    │   └── ConsultasModel.php
    └── Views/
        ├── view.php
        ├── buscar_ciudad.php
        ├── tiempo_ciudad.php
        └── historial.php
```

---

## Flujo de la aplicación

### 1. Búsqueda de ciudad
El usuario escribe el nombre de una ciudad en `buscar_ciudad.php`. El formulario envía el dato por POST a `BuscarCiudadController`, que llama a `OpenWeatherService::buscarCiudad()`. Este método consulta la API de geocoding de OpenWeatherMap y devuelve un array con las ciudades coincidentes (nombre, país, coordenadas). El controller registra la consulta como tipo `simple` en la base de datos y renderiza la view con los resultados.

### 2. Consulta del tiempo
Al hacer clic en una ciudad, el navegador redirige a `TiempoController` pasando las coordenadas por GET. El controller llama a dos métodos de `OpenWeatherService`: uno para el tiempo actual (`/data/2.5/weather`) y otro para la previsión de 5 días (`/data/2.5/forecast`). Con los datos obtenidos, registra la consulta como tipo `complejo` en la base de datos incluyendo temperatura y descripción del tiempo, y renderiza `tiempo_ciudad.php`.

### 3. Historial
`ConsultasController` llama a `ConsultasModel::listarConsultas()`, que devuelve todas las consultas registradas ordenadas por fecha descendente, y las pasa a `historial.php` para mostrarlas.

---

## Capa de datos — diseño escalable

La gestión de la base de datos se estructura en tres capas:

```
db_conexion.php  →  db_consultas.php  →  ConsultasModel.php
```

**`db_conexion.php`** gestiona exclusivamente la conexión PDO a PostgreSQL, leyendo las credenciales desde variables de entorno.

**`db_consultas.php`** expone métodos genéricos reutilizables: `selectUno`, `selectVarios` y `ejecutar`. Ninguna clase de la aplicación escribe SQL directamente excepto a través de esta clase.

**`ConsultasModel.php`** representa la tabla `consultas` y contiene los métodos específicos de negocio: `registrarConsulta` y `listarConsultas`. Si en el futuro se añaden nuevas tablas (usuarios, favoritos, alertas...), bastará con crear un nuevo Model que use `db_consultas` sin tocar nada de lo ya implementado.

Este diseño sigue el patrón **Repository**, donde cada Model encapsula las operaciones de su tabla y delega la ejecución a la capa genérica, facilitando el mantenimiento y la escalabilidad del proyecto.

---

## Base de datos

```sql
CREATE TABLE consultas (
    id          SERIAL PRIMARY KEY,
    ciudad      VARCHAR(100),
    tipo        VARCHAR(10) CHECK (tipo IN ('simple', 'complejo')),
    lat         DECIMAL(9,6),
    lon         DECIMAL(9,6),
    temp        DECIMAL(5,2),
    descripcion VARCHAR(100),
    fecha       TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## Despliegue con Docker

El proyecto usa tres contenedores orquestados con Docker Compose conectados en la red interna `red10`:

- **postgres** — PostgreSQL 16 Alpine. Expone el puerto `5433` en el host. Los datos persisten en el volumen `db_data` y el esquema se inicializa automáticamente desde `db/init.sql`.
- **php-fpm** — construido desde `web/Dockerfile` con PHP 8.2 FPM Alpine e instaladas las extensiones `pdo`, `pdo_pgsql` y `curl`. Monta `src/` como raíz de la aplicación y recibe las variables de entorno desde el `.env`.
- **nginx** — nginx Alpine. Expone el puerto `80` hacia el host y sirve los archivos de `src/`. Se comunica con php-fpm internamente a través de la red `red10`.

```
Host :80  →  nginx  →  php-fpm :9000  →  postgres :5432
```

Las credenciales y la API key se gestionan mediante un archivo `.env` que Docker Compose lee automáticamente. El archivo `.env` nunca debe subirse al repositorio.

```bash
# Levantar el proyecto
docker compose up -d

# Parar y eliminar contenedores
docker compose down

# Rebuild de la imagen php-fpm tras cambios en el Dockerfile
docker compose build --no-cache
docker compose up -d
```

---

## Variables de entorno requeridas

```env
POSTGRES_DB
POSTGRES_USER
POSTGRES_PASSWORD
API_KEY
```

## Advertencia
No se debe subir el `.env` publicamente y menos en este caso con la API KEY
