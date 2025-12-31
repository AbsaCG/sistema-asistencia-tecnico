# DATOS DE PRUEBA COMPLETOS - SISTEMA DE CONTROL DE ASISTENCIA

## 📊 Resumen de Datos Generados

### **Usuarios (Total: 94)**
- **1 Administrador**
  - Email: `admin@istp.edu.pe`
  - Password: `password`
  - Acceso completo al sistema

- **9 Profesores** (8 generados + 1 de prueba)
  - Email de prueba: `profesor@istp.edu.pe` / `password`
  - Profesores con especialidades variadas
  - Códigos: DOC0001 - DOC0008, DOC9999

- **81 Estudiantes** (80 generados + 1 de prueba)
  - Email de prueba: `estudiante@istp.edu.pe` / `password`
  - Distribuidos en 10 carreras técnicas
  - Códigos: EST20250001 - EST20250080, EST20259999

### **Contenido Académico**

#### **10 Carreras Técnicas:**
1. Producción Agropecuaria (PA-2024)
2. Ganadería (GAN-2024)
3. Contabilidad (CONT-2024) - **13 estudiantes**
4. Administración de Empresas (ADM-2024)
5. Marketing Digital (MDIG-2024)
6. Desarrollo de Software (DEVSW-2024) - **10 estudiantes**
7. Soporte Técnico en TI (STTI-2024) - **12 estudiantes**
8. Administración de Hoteles y Turismo (AHT-2024) - **10 estudiantes**
9. Gastronomía (GAST-2024) - **8 estudiantes**
10. Enfermería Técnica (ENFER-2024)

#### **30 Cursos Diversos:**
- Matemática I, Comunicación, Computación Básica
- Inglés I, Química General, Física I
- Estadística, Contabilidad Básica, Administración I
- Marketing, Programación I, Base de Datos, Redes
- Cocina Básica, Pastelería, Nutrición
- Enfermería Básica, Anatomía
- Ganadería, Agricultura, Veterinaria Básica
- Turismo I, Hotelería, Gestión Empresarial
- Economía, Derecho Laboral, Ética Profesional, Emprendimiento

### **📅 Asistencias (Total: 1,920 registros)**

**Período:** Últimos 30 días (del 02/12/2025 al 31/12/2025)

**Distribución por Estado:**
- ✅ **Presentes:** 1,640 (85.4%)
- ⏰ **Tarde:** 189 (9.8%)
- ❌ **Ausentes:** 91 (4.7%)

**Características:**
- 80% de estudiantes registran asistencia diariamente
- Horarios de registro: 7:00 AM - 10:00 AM
- Fuente: `in_class` (registro en clase)
- Ubicación: "Entrada Principal"

---

## 🔑 Credenciales de Prueba

### **Para Administradores:**
```
Email: admin@istp.edu.pe
Password: password
Rol: Administrador (acceso total)
```

### **Para Profesores:**
```
Email: profesor@istp.edu.pe
Password: password
Rol: Profesor
Código: DOC9999
```

### **Para Estudiantes:**
```
Email: estudiante@istp.edu.pe
Password: password
Rol: Estudiante
Código: EST20259999
Carrera: Producción Agropecuaria
Semestre: 1
```

### **Todos los usuarios generados:**
- Contraseña: `password`
- Emails profesores: `carlos.mendoza@istp.edu.pe`, `maria.torres@istp.edu.pe`, etc.
- Emails estudiantes: formato `nombre.apellido[numero]@estudiante.istp.edu.pe`

---

## 📈 Datos para Dashboard

Los datos generados permiten visualizar:

1. **Gráfico de línea (últimos 7 días):**
   - ~250-280 registros de asistencia por día
   - Tendencia estable con alta tasa de asistencia

2. **Gráfico de dona (hoy):**
   - 85% presentes
   - 10% tarde
   - 5% ausentes

3. **Gráfico de barras (por carrera):**
   - Contabilidad: mayor cantidad de estudiantes (13)
   - Soporte Técnico en TI: 12 estudiantes
   - Desarrollo de Software: 10 estudiantes
   - Distribución variada en todas las carreras

---

## 🎯 Casos de Uso para Testing

### **1. Registro de Asistencia:**
- Lista de 80 estudiantes disponibles
- Diferentes estados para probar (presente, tarde, ausente)
- Validación de fechas y horarios

### **2. Reportes:**
- 1,920 registros para filtrar
- 30 días de historial
- 10 carreras para comparar
- Exportación a PDF/Excel con datos reales

### **3. Gestión de Estudiantes:**
- 80 estudiantes con datos completos
- DNI, código, email, teléfono
- Información de contacto de padres
- Distribución en 6 semestres

### **4. Gestión de Profesores:**
- 8 profesores con especialidades
- Códigos únicos
- Información de contacto completa

### **5. Dashboard Administrativo:**
- Estadísticas reales de asistencia
- Tendencias de 30 días
- Comparativas por carrera
- Alertas de inasistencias

---

## ⚙️ Comandos Útiles

### **Ver resumen de datos:**
```bash
php scripts/show_data_summary.php
```

### **Regenerar todos los datos:**
```bash
php artisan migrate:fresh --seed
php artisan db:seed --class=CompleteDataSeeder
php artisan db:seed --class=TestUsersSeeder
```

### **Solo agregar datos de prueba:**
```bash
php artisan db:seed --class=CompleteDataSeeder
php artisan db:seed --class=TestUsersSeeder
```

### **Verificar usuarios en tinker:**
```bash
php artisan tinker --execute="App\Models\User::with('role')->get(['name','email'])"
```

---

## 📝 Notas Importantes

1. **Todos los usuarios tienen contraseña: `password`**
2. Los DNIs son ficticios (formato 7XXXXXXX)
3. Los teléfonos son aleatorios (formato 9XXXXXXXX)
4. Las direcciones son ficticias
5. Los nombres son generados aleatoriamente
6. Las asistencias están distribuidas uniformemente en 30 días
7. El 85% de asistencia refleja un nivel normal/bueno

---

## 🚀 Estado del Sistema

✅ Base de datos completamente poblada
✅ Relaciones entre modelos funcionando
✅ Datos realistas para pruebas
✅ Dashboard con información suficiente
✅ Reportes con datos históricos
✅ Usuarios de prueba para cada rol

**Fecha de generación:** 31 de diciembre de 2025
**Versión del sistema:** Laravel 11 + Inertia.js v2 + Vue 3
