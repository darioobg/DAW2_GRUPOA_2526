# DAW2_GRUPOA_2526

| Nombre   |
|----------|
| 👤 **Darío Briongos García**       
| 📝 **Maria Colio Tresgallo**       
| 📌 **Raul Calderon Gómez**
| 💻 **Jino Olivera Rudas**        

composer install
copy .env.example .env
php artisan key:generate
php artisan serve

php artisan vendor:publish --tag=reliese-models
php artisan code:models

composer require prettus/l5-repository

php artisan vendor:publish --provider="Prettus\Repository\Providers\RepositoryServiceProvider"

php artisan make:repository PrioridadRepository

php artisan make:repository ProyectoRepository

php artisan make:repository TareaRepository

php artisan make:repository EstadoTareaRepository

php artisan make:repository CanalNotificacionRepository

php artisan make:repository RolEmpresaRepository

php artisan make:repository RolEquipoRepository

php artisan make:repository TipoNotificacionRepository

php artisan make:repository UsuarioRepository

php artisan make:repository EstadoProyectoRepository

php artisan make:repository ComentarioRepository

php artisan make:repository EquipoRepository

php artisan make:repository EmpresaRepository

php artisan make:repository NotificacionRepository

php artisan make:repository UsuarioEquipoRepository

php artisan make:repository UsuarioEmpresaRepository


