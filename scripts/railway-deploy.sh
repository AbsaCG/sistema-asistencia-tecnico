#!/bin/bash
set -e

echo "🚀 Railway Deployment Script"
echo "============================"

# Generar APP_KEY si no existe
if [ -z "$APP_KEY" ]; then
    echo "📝 Generando APP_KEY..."
    php artisan key:generate --force
fi

# Ejecutar migraciones
echo "🗄️  Ejecutando migraciones..."
php artisan migrate --force --no-interaction

# Verificar si existen roles
echo "🔍 Verificando datos iniciales..."
ROLE_COUNT=$(php artisan tinker --execute="echo \App\Models\Role::count();")

if [ "$ROLE_COUNT" -eq "0" ]; then
    echo "📦 Base de datos vacía, ejecutando seeders..."
    
    # Ejecutar RoleSeeder
    echo "   → RoleSeeder..."
    php artisan db:seed --class=RoleSeeder --force
    
    # Ejecutar CompleteDataSeeder
    echo "   → CompleteDataSeeder (80 estudiantes, 1920 asistencias)..."
    php artisan db:seed --class=CompleteDataSeeder --force
    
    echo "✅ Seeders ejecutados exitosamente"
else
    echo "✅ Datos ya existen, omitiendo seeders"
fi

# Limpiar cachés
echo "🧹 Limpiando cachés..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

echo "✨ Deployment completado exitosamente!"
