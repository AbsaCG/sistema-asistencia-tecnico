# 🚂 Railway Deployment Guide

## Pasos para Deploy Automático

### 1. Configurar Railway

1. Ve a https://railway.app/dashboard
2. **New Project** → **Deploy from GitHub repo**
3. Selecciona: `AbsaCG/sistema-asistencia-tecnico`
4. Railway detectará automáticamente Laravel

### 2. Agregar Base de Datos

En tu proyecto Railway:
- Click **"+ New"** → **"Database"** → **"Add MySQL"**
- Espera que se cree (1-2 minutos)

### 3. Configurar Variables de Entorno

Ve a tu servicio Laravel → **"Variables"** → **"RAW Editor"**

Copia y pega esto:

```env
APP_NAME=Control Asistencia ISTP
APP_ENV=production
APP_DEBUG=false
APP_URL=${{RAILWAY_PUBLIC_DOMAIN}}

DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}

SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
LOG_CHANNEL=stack
```

### 4. Deploy Automático

Railway ejecutará automáticamente:
- ✅ `composer install`
- ✅ `npm install && npm run build`
- ✅ `php artisan migrate --force`
- ✅ `php artisan db:seed --class=RoleSeeder`
- ✅ `php artisan db:seed --class=CompleteDataSeeder`
- ✅ Cachés de configuración

### 5. Verificar Deploy

1. Espera que el deploy termine (5-10 minutos)
2. Click en **"View Logs"** para ver el progreso
3. Busca el mensaje: `✨ Deployment completado exitosamente!`
4. Abre tu URL pública

### 6. Credenciales de Acceso

Una vez deployado, usa estas credenciales:

**Admin:**
- Email: `admin@istp.edu.pe`
- Password: `password`

**Profesor:**
- Email: `profesor@istp.edu.pe`
- Password: `password`

**Estudiante:**
- Email: `estudiante@istp.edu.pe`
- Password: `password`

## Datos Incluidos

El seeder automático crea:
- 🔐 3 roles (Admin, Docente, Estudiante)
- 👥 92 usuarios (1 admin, 9 docentes, 81 estudiantes, 1 staff)
- 👨‍🎓 80 estudiantes con datos completos
- 📚 30 cursos
- 🎓 10 carreras técnicas
- 📊 1920 registros de asistencia (últimos 30 días)

## Troubleshooting

### Error: APP_KEY not found
```bash
# En Railway Terminal
php artisan key:generate --show
# Copia el resultado y agrégalo como variable APP_KEY
```

### Error: Database connection
Verifica que las variables de MySQL estén correctamente referenciadas:
```
DB_HOST=${{MySQL.MYSQLHOST}}
```

### Logs
```bash
# Ver logs en tiempo real
railway logs
```

## Redeploy Manual

Si necesitas forzar un redeploy:
```bash
git commit --allow-empty -m "redeploy"
git push absacg main
```

## Comandos Útiles en Railway Terminal

```bash
# Ver estado de la BD
php artisan tinker
>>> \App\Models\User::count();
>>> \App\Models\Student::count();

# Recrear datos
php artisan migrate:fresh --seed --force

# Limpiar cachés
php artisan optimize:clear
```
