# DAW2_GRUPOA_2526

| TASKFLOW|
| ------ |

**TaskFlow** es una aplicación web de gestión de tareas y proyectos orientada a estudiantes, emprendedores y pequeños equipos.  
Permite organizar el trabajo mediante tableros Kanban, facilitando la planificación, el seguimiento y la colaboración de forma sencilla e intuitiva.

El proyecto ha sido desarrollado siguiendo una arquitectura moderna basada en una API REST con Laravel y un frontend desacoplado en React, incorporando además un sistema de despliegue automatizado para entornos de producción.

---

## 🧠 Descripción del proyecto

TaskFlow nace como una alternativa ligera frente a herramientas de gestión de proyectos complejas. Está diseñado para cubrir las necesidades básicas de organización sin sacrificar usabilidad ni claridad, permitiendo a los usuarios centrarse en el trabajo y no en la herramienta.

Entre sus objetivos principales se encuentran:

- Organización de proyectos y tareas  
- Gestión visual mediante tableros Kanban  
- Colaboración en pequeños equipos  
- Autenticación segura de usuarios  
- Despliegue automatizado en servidor Linux  

---

## 🏗️ Arquitectura

La aplicación sigue una arquitectura cliente-servidor desacoplada:

Frontend (React)  
⬇  
API REST (Laravel)  
⬇  
Base de datos (MariaDB / MySQL)

En producción:

- NGINX actúa como servidor web  
- PHP-FPM ejecuta la API Laravel  
- MariaDB gestiona la persistencia de datos  
- React se sirve como aplicación web estática optimizada  

La comunicación entre frontend y backend se realiza mediante peticiones HTTP siguiendo el modelo REST.

---

## 🛠️ Tecnologías utilizadas

- Backend: Laravel (PHP 8.3)  
- Frontend: React + Vite  
- Base de datos: MariaDB / MySQL  
- Servidor web: NGINX  
- Sistema operativo: Ubuntu Server 24.04  
- Automatización: Script Bash  
- Control de versiones: Git y GitHub  

---

## 📁 Estructura del repositorio
```
Version01/
├── api/                    # Backend Laravel (API REST)
├── frontend/
│   └── react-taskflow/     # Frontend React
README.md
Scripts
    └── deploy.sh   # Script automático de despliegue
DOCUMENTACION       #Documentacion
    └──TaskFlow.pdf 
```

---
## 📂 Recursos del proyecto

### ⚙️ Scripts
- [Carpeta Scripts](Scripts/)
- [Script de despliegue automático](Scripts/deploy.sh)

### 📚 Documentación
- [Carpeta DOCUMENTACION](DOCUMENTACION/)
- [Memoria del proyecto](DOCUMENTACION/TaskFlow.pdf)
- [Link Figma](DOCUMENTACION/LinkFigma.txt)
- [Diagramas Clase y entidad relación](DOCUMENTACION/Fuentes/DiagramasEntidadRelacionClases)
- [Diagramas](DOCUMENTACION/Fuentes/Diagramas)
- [Hojas de Calculo](DOCUMENTACION/Fuentes/HojasdeCalculo)


## ⚙️ Instalación en entorno local

### 1. Clonar el repositorio

```bash
git clone https://github.com/usuario/taskflow.git
cd taskflow
```

### 2. Backend (Laravel)

```bash
cd Version01/api
composer install
cp .env.example .env
```

Configurar las credenciales de la base de datos en el archivo `.env` y ejecutar:

```bash
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

La API quedará disponible en:

```
http://localhost:8000
```

### 3. Frontend (React)

```bash
cd Version01/frontend/react-taskflow
npm install
```

Crear el archivo `.env`:

```
VITE_API_URL=http://ip:8000/api
```

Iniciar el servidor de desarrollo:

```bash
npm run dev
```

---

## 🚀 Despliegue en producción

El proyecto incluye un script de despliegue automático diseñado para servidores con Ubuntu Server 24.04.

### Pasos básicos

```bash
chmod +x deploy.sh
sudo ./deploy.sh
```

### ¿Qué hace el script?

El script automatiza completamente el proceso de despliegue:

- Actualiza el sistema operativo  
- Instala NGINX, PHP 8.3 y extensiones necesarias  
- Instala MariaDB y configura la base de datos  
- Instala Composer y Node.js si no están presentes  
- Configura automáticamente el archivo `.env`  
- Ejecuta migraciones y seeders  
- Compila el frontend React  
- Configura NGINX para servir frontend y API  
- Deja la aplicación accesible desde la IP pública del servidor  

---

## 🔐 Seguridad

- Las contraseñas se almacenan mediante hashing seguro (bcrypt / Argon2).  
- No se almacenan contraseñas en texto plano.  
- Validación de datos en el backend.  
- Separación de usuario de base de datos.  
- Arquitectura preparada para HTTPS.  

---

## 📊 Funcionalidades principales

- Registro e inicio de sesión de usuarios  
- Gestión de proyectos  
- Creación y organización de tareas  
- Tablero Kanban  
- Backend API REST  
- Frontend desacoplado  
- Despliegue automatizado  

---

## 🔮 Futuras mejoras

- Notificaciones en tiempo real  
- Integración con servicios externos  
- Aplicación móvil  
- Sistema de roles avanzado  
- Panel de estadísticas  
- Implementación de HTTPS con certificados SSL  

---

## 👨‍💻 Autor

Proyecto desarrollado con fines académicos dentro del ciclo formativo de Desarrollo de Aplicaciones Web (DAW).

| 👤 **Darío Briongos García**  
| 📝 **Maria Colio Tresgallo**  
| 📌 **Raul Calderon Gómez**
| 💻 **Jino Olivera Rudas**
---

## 📄 Licencia

Proyecto de uso educativo.  
