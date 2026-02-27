#!/bin/bash

# ==============================================================================
# SCRIPT DE DESPLIEGUE AUTOMÁTICO - TASKFLOW (Ubuntu 24.04)
# ==============================================================================
set -e # Detiene el script inmediatamente si algún comando falla

echo "🚀 Iniciando despliegue automático de Taskflow..."

# --- 1. CONFIGURACIÓN (Variables Fijas) ---
DB_NAME="taskflow_db"
DB_USER="taskflow_user"
DB_PASS="Taskflow_2026_Secure!"
DEPLOY_DIR="/var/www/taskflow"

# Detectar la IP pública automáticamente
PUBLIC_IP=$(curl -s http://checkip.amazonaws.com || curl -s ifconfig.me)
echo "🌐 IP Pública detectada: $PUBLIC_IP"

# Encontrar el repositorio (Busca Version01 independientemente de dónde esté el script)
SCRIPT_DIR=$(cd "$(dirname "${BASH_SOURCE[0]}")" &> /dev/null && pwd)
if [ -d "$SCRIPT_DIR/Version01" ]; then
    REPO_DIR="$SCRIPT_DIR"
elif [ -d "$(dirname "$SCRIPT_DIR")/Version01" ]; then
    REPO_DIR=$(dirname "$SCRIPT_DIR")
else
    echo "❌ ERROR: No encuentro la carpeta Version01. Asegúrate de ejecutar el script dentro del repositorio."
    exit 1
fi
echo "📂 Repositorio detectado en: $REPO_DIR"

# --- 2. ACTUALIZACIÓN E INSTALACIÓN DE DEPENDENCIAS ---
echo "📦 Instalando dependencias del servidor..."
apt update && apt upgrade -y
apt install -y nginx mariadb-server curl unzip git
apt install -y php8.3-fpm php8.3-mysql php8.3-mbstring php8.3-xml php8.3-bcmath php8.3-curl php8.3-zip

if ! command -v composer &> /dev/null; then
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
fi

if ! command -v node &> /dev/null; then
    curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
    apt install -y nodejs
fi

# --- 3. CONFIGURACIÓN DE BASE DE DATOS ---
echo "🗄️ Configurando base de datos..."
mysql -e "CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\`;"
mysql -e "CREATE USER IF NOT EXISTS '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASS}';"
mysql -e "GRANT ALL PRIVILEGES ON \`${DB_NAME}\`.* TO '${DB_USER}'@'localhost';"
mysql -e "FLUSH PRIVILEGES;"

# --- 4. PREPARACIÓN DE CARPETAS ---
echo "📂 Moviendo el proyecto a $DEPLOY_DIR..."
rm -rf $DEPLOY_DIR # Borra instalaciones anteriores si las hubiera
mkdir -p $DEPLOY_DIR
cp -r $REPO_DIR/Version01/api $DEPLOY_DIR/api
cp -r $REPO_DIR/Version01/frontend/react-taskflow $DEPLOY_DIR/frontend
chown -R www-data:www-data $DEPLOY_DIR

# --- 5. CONFIGURACIÓN DEL BACKEND (LARAVEL) ---
echo "⚙️ Configurando la API (Laravel)..."
cd $DEPLOY_DIR/api
cp .env.example .env
sed -i "s/^DB_DATABASE=.*/DB_DATABASE=$DB_NAME/" .env
sed -i "s/^DB_USERNAME=.*/DB_USERNAME=$DB_USER/" .env
sed -i "s/^DB_PASSWORD=.*/DB_PASSWORD=$DB_PASS/" .env
sed -i "s|^APP_URL=.*|APP_URL=http://$PUBLIC_IP|" .env
sed -i "s/^SESSION_DOMAIN=.*/SESSION_DOMAIN=$PUBLIC_IP/" .env
sed -i "s/^SANCTUM_STATEFUL_DOMAINS=.*/SANCTUM_STATEFUL_DOMAINS=$PUBLIC_IP/" .env

# Le damos la propiedad del .env al usuario web
chown www-data:www-data .env

# --- PARCHE PARA APIS SIN VISTAS ---
# Creamos las carpetas de vistas vacías para que artisan no se queje al limpiar la caché
mkdir -p resources/views
mkdir -p storage/framework/views
chown -R www-data:www-data resources storage

sudo -u www-data composer install --no-interaction --optimize-autoloader
sudo -u www-data php artisan key:generate
sudo -u www-data php artisan migrate:fresh --seed --force

# El || true evita que el script aborte si la caché de vistas u otra sigue dando la lata
sudo -u www-data php artisan optimize:clear || true 

chmod -R 775 storage bootstrap/cache

# --- 6. CONFIGURACIÓN DEL FRONTEND (REACT) ---
echo "⚛️ Compilando el Frontend (React)..."
cd $DEPLOY_DIR/frontend
echo "VITE_API_URL=http://$PUBLIC_IP/api/v1" > .env
npm install
npm run build
chown -R www-data:www-data dist

# --- 7. CONFIGURACIÓN DE NGINX ---
echo "🌐 Configurando Nginx..."
cat <<EOF > /etc/nginx/sites-available/taskflow
server {
    listen 80 default_server;
    server_name _;

    root $DEPLOY_DIR/frontend/dist;
    index index.html;

    location / {
        try_files \$uri \$uri/ /index.html;
    }

    location /api {
        alias $DEPLOY_DIR/api/public;
        try_files \$uri \$uri/ @api;
    }

    location @api {
        rewrite ^/api/(.*)$ /api/index.php?\$query_string last;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $DEPLOY_DIR/api/public/index.php;
        fastcgi_param SCRIPT_NAME /index.php;
    }
}
EOF

ln -sf /etc/nginx/sites-available/taskflow /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default
systemctl restart nginx

echo "✅ ¡DESPLIEGUE DE TASKFLOW COMPLETADO CON ÉXITO!"
echo "👉 Entra a tu aplicación en: http://$PUBLIC_IP"