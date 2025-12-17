# Arquitectura

TaskFlow utiliza una arquitectura moderna basada en API, donde Laravel implementa una capa de negocio y una capa de datos totalmente desacopladas. El frontend consume los servicios mediante Fetch API y renderiza las interfaces dinámicamente usando Bootstrap.

La aplicación se estructura en capas: API → Servicios → Repositorios → Base de Datos, y se utilizan ViewModels para preparar y transformar las respuestas enviadas al cliente.
```
┌───────────────────────────────┐
│             FRONTEND          │
│  HTML + CSS (Bootstrap)       │
│  JavaScript (Fetch API)       │
│  UI Components                │
│  Manejo de errores (popups)   │
└───────────────┬───────────────┘
                │ JSON (Fetch)
┌───────────────▼───────────────┐
│             API                │
│ Laravel Controllers API        │
│ Routes /api/...                │
│ Middleware (auth más adelante) │
│ ErrorResponse Handler          │
└───────────────┬───────────────┘
                │ llama servicios
┌───────────────▼───────────────┐
│       CAPA DE NEGOCIO         │
│ Services/                     │
│  - reglas del negocio         │
│  - validaciones               │
│  - excepciones                │
│  - crear ViewModels           │
└───────────────┬───────────────┘
                │ llama repositorios
┌───────────────▼───────────────┐
│      CAPA DE DATOS            │
│ Repositories/                 │
│   - consultas SQL             │
│   - selects / inserts         │
│   - no lógica                 │
└───────────────┬───────────────┘
                │
┌───────────────▼───────────────┐
│             MySQL             │
└───────────────────────────────┘
```

# Estructura

```
taskflow/
│
├── frontend/                      ← HTML, CSS, JS, Bootstrap
│   ├── index.html
│   ├── css/
│   │    ├── bootstrap.min.css
│   │    ├── main.css
│   │    └── componentes/
│   ├── js/
│   │    ├── app.js
│   │    ├── servicios/
│   │    │      ├── tableros.api.js
│   │    │      ├── tareas.api.js
│   │    │      └── login.api.js
│   │    ├── ui/
│   │    │      ├── pintarTableros.js
│   │    │      └── pintarTareas.js
│   │    └── eventos/
│   │           ├── tableroEventos.js
│   │           └── loginEventos.js
│   └── img/
│
├── backend/                       ← Proyecto Laravel
│   ├── app/
│   │   ├── Http/
│   │   │    ├── Controllers/Api/
│   │   │    │          TableroController.php
│   │   │    │          TareaController.php
│   │   │    │          AuthController.php
│   │   │    └── Middleware/
│   │   ├── Services/
│   │   │      TableroService.php
│   │   │      TareaService.php
│   │   │      AuthService.php
│   │   ├── Repositories/
│   │   │      TableroRepository.php
│   │   │      TareaRepository.php
│   │   ├── ViewModels/
│   │   │      TableroViewModel.php
│   │   │      TareaViewModel.php
│   │   └── Exceptions/
│   │          ApiException.php
│   ├── routes/
│   │      api.php
│   ├── database/
│   │      migrations/
│   │      seeders/
│   └── composer.json
│
├── docs/                          ← Pencil / Visio / Prototipos
│   ├── login.png
│   ├── dashboard.png
│   ├── tableros.png
│   └── tareas.png
│
└── README.md
```

# Esquema funcional

```
[ Usuario ] 
     ↓
[ Frontend ] 
     - Bootstrap layout
     - JS crea tarjetas, tableros, tareas
     - Fetch API
     ↓
[ API Laravel ]  
     - recibe peticiones
     - maneja errores
     - retorna JSON
     ↓
[ Services ]
     - reglas del negocio
     - validaciones
     - ViewModels
     ↓
[ Repositories ]
     - consultas SQL limpias
     ↓
[ Base de Datos MySQL ]
```

# Flujo extendido
```
┌────────────────────────┐
│   Usuario hace acción  │
│  (Crear tablero, tarea │
│   mover tarjeta, etc.) │
└───────────────┬────────┘
                │ evento JS
                ▼
┌────────────────────────┐
│   FRONTEND JS          │
│ - Captura evento       │
│ - Valida dato básico   │
│ - Envía Fetch API      │
└───────────────┬────────┘
                │ JSON
                ▼
┌────────────────────────┐
│      API Laravel       │
│ - Recibe petición      │
│ - Maneja errores       │
│ - Llama al Service     │
└───────────────┬────────┘
                ▼
┌────────────────────────┐
│      Servicio (BL)     │
│ - Regla de negocio     │
│ - Validaciones         │
│ - Llama repositorio    │
└───────────────┬────────┘
                ▼
┌────────────────────────┐
│      Repositorio       │
│ - Ejecuta SQL seguro   │
│ - Devuelve datos crudos│
└───────────────┬────────┘
                ▼
┌────────────────────────┐
│        MySQL           │
│ - INSERT / SELECT      │
└───────────────┬────────┘
                ▼
┌────────────────────────┐
│     Servicio            │
│ - Crea ViewModel        │
│ - Formatea datos        │
└───────────────┬────────┘
                ▼
┌────────────────────────┐
│   API responde JSON    │
│  { ok, data, mensaje } │
└───────────────┬────────┘
                ▼
┌────────────────────────┐
│  JS renderiza UI       │
│  (DOM / Bootstrap)     │
└────────────────────────┘
```

# Arquitectura extendida
```

                               ┌────────────────────────────────┐
                               │            FRONTEND             │
                               │────────────────────────────────│
                               │ HTML + CSS (Bootstrap 5)       │
                               │ JavaScript (Fetch API)         │
                               │ Componentes UI dinámicos        │
                               │ Manejador de errores (Popups)   │
                               └───────────────┬────────────────┘
                                               │ JSON (Fetch)
                                               ▼
┌─────────────────────────────────────────────────────────────────────────┐
│                               API LARAVEL                                │
│─────────────────────────────────────────────────────────────────────────│
│   routes/api.php                                                        │
│       /api/tableros                                                     │
│       /api/tareas                                                       │
│       /api/login                                                        │
│                                                                         │
│   Controladores API (no MVC de vistas)                                  │
│       TableroController.php                                             │
│       TareaController.php                                               │
│       AuthController.php                                                 │
│                                                                         │
│   Middleware (autenticación en etapa 2)                                 │
│                                                                         │
│   Manejador global de errores                                           │
│       ApiException.php → Respuesta JSON uniforme                        │
└───────────────┬─────────────────────────────────────────────────────────┘
                │ llama a Services
                ▼
┌──────────────────────────────────────────────────────────────────────────┐
│                            CAPA DE NEGOCIO (SERVICES)                    │
│──────────────────────────────────────────────────────────────────────────│
│   Regla de negocio                                                       │
│   Validaciones                                                           │
│   Excepciones de lógica                                                  │
│   Conversión a ViewModel                                                 │
│                                                                          │
│   TableroService.php                                                     │
│   TareaService.php                                                       │
│   UsuarioService.php                                                     │
└───────────────┬──────────────────────────────────────────────────────────┘
                │ llama a Repositories
                ▼
┌──────────────────────────────────────────────────────────────────────────┐
│                         CAPA DE DATOS (REPOSITORIES)                     │
│──────────────────────────────────────────────────────────────────────────│
│   Acceso directo a MySQL                                                 │
│   SELECT / INSERT / UPDATE / DELETE                                      │
│   Sin lógica (solo queries)                                              │
│                                                                          │
│   TableroRepository.php                                                  │
│   TareaRepository.php                                                    │
│   UsuarioRepository.php                                                  │
└───────────────┬──────────────────────────────────────────────────────────┘
                │ devuelve filas puras
                ▼
┌──────────────────────────────────────────────────────────────────────────┐
│                                BASE DE DATOS                             │
│──────────────────────────────────────────────────────────────────────────│
│   MySQL / MariaDB                                                        │
│   Tablas normalizadas:                                                   │
│       tableros                                                           │
│       listas                                                             │
│       tareas                                                             │
│       usuarios                                                           │
│       miembros_tablero                                                   │
└──────────────────────────────────────────────────────────────────────────┘
```