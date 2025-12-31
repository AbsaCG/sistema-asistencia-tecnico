# 🎓 ISTP CONTROL - Plan Ejecutivo
## Sistema de Gestión de Asistencia para Instituto Superior Tecnológico

**Versión:** 1.0.0-alpha  
**Fecha:** 30 de Diciembre de 2025  
**Estado:** ✅ FASE 1 COMPLETADA

---

## 📋 Resumen Ejecutivo

Sistema profesional para gestionar asistencia en Institutos Superiores Tecnológicos con:
- **10 Carreras Técnicas** completamente configuradas
- **Base de datos mejorada** con DNI, contactos y documentación
- **Dashboard administrativo** con estadísticas en tiempo real
- **Interfaz moderna** responsive para todos los dispositivos

---

## 🏫 Carreras Técnicas Disponibles

### ÁREA AGROPECUARIA
1. **Producción Agropecuaria** (PA-2024)
   - Duración: 4 semestres
   - Créditos: 120
   - Matrícula: S/. 450
   - Coordinador: Ing. Juan Rojas

2. **Ganadería** (GAN-2024)
   - Duración: 4 semestres
   - Créditos: 120
   - Matrícula: S/. 450

### ÁREA ADMINISTRACIÓN
3. **Contabilidad** (CONT-2024)
   - Duración: 4 semestres
   - Matrícula: S/. 400
   - Coordinadora: CPC. María García

4. **Administración de Empresas** (ADM-2024)
   - Duración: 4 semestres
   - Matrícula: S/. 400
   - Coordinador: Lic. Pedro López

5. **Marketing Digital** (MDIG-2024)
   - Duración: 4 semestres
   - Matrícula: S/. 400
   - Coordinadora: Lic. Ana Suárez

### ÁREA INFORMÁTICA
6. **Desarrollo de Software** (DEVSW-2024)
   - Duración: 4 semestres
   - Matrícula: S/. 500
   - Coordinador: Ing. Roberto Silva

7. **Soporte Técnico en TI** (STTI-2024)
   - Duración: 4 semestres
   - Matrícula: S/. 480
   - Coordinador: Ing. Luis Fernández

### ÁREA HOTELERÍA Y TURISMO
8. **Administración de Hoteles y Turismo** (AHT-2024)
   - Duración: 4 semestres
   - Matrícula: S/. 420
   - Coordinadora: Lic. Patricia Romero

9. **Gastronomía** (GAST-2024)
   - Duración: 4 semestres
   - Matrícula: S/. 480
   - Coordinador: Chef. Francisco Díaz

### ÁREA SALUD
10. **Enfermería Técnica** (ENFER-2024)
    - Duración: 4 semestres
    - Matrícula: S/. 520
    - Coordinadora: Lic. Enf. Rosa Campos

---

## 📊 Estructura de Base de Datos Mejorada

### Tabla: STUDENTS (Estudiantes)
```
Campos de Identificación:
├── dni              VARCHAR(12) - DNI único
├── student_code     VARCHAR - Código de estudiante generado
├── email            VARCHAR - Email institucional
├── phone            VARCHAR - Teléfono personal

Campos Académicos:
├── semester         INT - Semestre actual (1-4)
├── enrollment_date  DATETIME - Fecha de inscripción
├── scholarship_status ENUM - ninguno/parcial/completo
├── student_status   ENUM - activo/inactivo/egresado/retirado

Campos de Contacto:
├── parent_name      VARCHAR - Apoderado/Tutor
├── parent_email     VARCHAR - Email apoderado
├── parent_phone     VARCHAR - Teléfono apoderado
├── emergency_contact_name VARCHAR
├── emergency_contact_phone VARCHAR

Campos Adicionales:
├── address          TEXT - Dirección
├── birth_date       DATE - Fecha de nacimiento
├── photo            VARCHAR - Ruta de foto
├── observations     TEXT - Notas del sistema
├── attachment_path  VARCHAR - Documentos de admisión
```

### Tabla: TECHNICAL_CAREERS (Carreras Técnicas)
```
├── id               BIGINT PRIMARY KEY
├── name             VARCHAR - Nombre carrera
├── slug             VARCHAR - URL slug
├── code             VARCHAR - Código (PA-2024, etc)
├── description      TEXT - Descripción
├── duration_semesters INT - 4 semestres típicamente
├── total_credits    INT - 120 créditos
├── coordinator_name VARCHAR - Coordinador
├── coordinator_email VARCHAR - Email coordinador
├── requirements     TEXT - Requisitos ingreso
├── tuition_amount   DECIMAL - Costo matrícula
├── is_active        BOOLEAN - Estado activo
├── created_at       TIMESTAMP
├── updated_at       TIMESTAMP
```

---

## 🎯 Funcionalidades Actuales

### ✅ Completadas (FASE 1)

**Autenticación y Seguridad:**
- ✓ Login seguro con bcrypt
- ✓ Roles y Permisos (Admin, Profesor, Apoderado, Estudiante)
- ✓ CSRF protection
- ✓ Session management

**Gestión Académica:**
- ✓ 10 Carreras Técnicas precargadas
- ✓ Estructura de estudiantes mejorada
- ✓ Asignación de carrera por estudiante
- ✓ Control de semestre

**Dashboard Administrativo:**
- ✓ Estadísticas en tiempo real
- ✓ Contador de estudiantes
- ✓ Porcentaje de asistencia
- ✓ Carreras activas

**Interfaz de Usuario:**
- ✓ Página profesional de Carreras Técnicas
- ✓ Tarjetas coloridas con información
- ✓ Responsive design (mobile-first)
- ✓ Menú de navegación intuitivo

**Usuarios de Prueba:**
- Admin: admin@example.com / password
- Profesor: ana@example.com / password
- Apoderado: padre@example.com / password

---

## 🔄 FASE 2: Próximas Funcionalidades

### 📅 Horarios y Bloques de Clase
- [ ] Sistema de bloques horarios
- [ ] Asignación de aulas
- [ ] Validación por bloque
- [ ] Interfaz de visualización

### 📋 Justificaciones de Inasistencia
- [ ] Formulario de solicitud
- [ ] Tipos de justificación
- [ ] Carga de documentos
- [ ] Flujo de aprobación

### 📊 Reportes Avanzados
- [ ] Asistencia por carrera
- [ ] Reportes PDF profesionales
- [ ] Exportación Excel
- [ ] Gráficos estadísticos

---

## 🛠️ Stack Tecnológico

| Componente | Tecnología |
|-----------|-----------|
| Backend | Laravel 11 |
| Frontend | Vue 3 + Inertia.js |
| BD | MySQL 5.7+ |
| Estilos | Tailwind CSS |
| Build | Vite v6 |
| Testing | PHPUnit |
| Auth | Sanctum + Sessions |
| Deploy | GitHub Actions |

---

## 📈 Estadísticas del Sistema

```
┌─────────────────────────┐
│ ISTP Control v1.0       │
├─────────────────────────┤
│ Carreras Técnicas:  10  │
│ Tablas BD:          29  │
│ Migraciones:        14  │
│ Modelos:            16+ │
│ Componentes Vue:    13+ │
│ Tests:              7   │
│ Líneas Código:     6000+│
└─────────────────────────┘
```

---

## 🔐 Seguridad Implementada

✅ Autenticación con bcrypt  
✅ CSRF tokens en todas las formas  
✅ Validación de entrada en backend  
✅ Protección contra SQL injection  
✅ XSS protection  
✅ Rate limiting (próximo)  
✅ 2FA (próximo)  
✅ Logs de auditoría (próximo)  

---

## 📞 Información del Sistema

**URL de Acceso:** http://127.0.0.1:8000  
**Base de Datos:** MySQL proyecto_asistencia  
**Admin:** admin@example.com / password  
**Versión PHP:** 8.2+  
**Versión Node:** 18+  

---

## 🎓 Roles y Permisos

| Rol | Acceso |
|-----|--------|
| **Admin** | Todo (usuarios, carreras, reportes, config) |
| **Profesor** | Asistencia, estudiantes, reportes básicos |
| **Apoderado** | Asistencia de su(s) estudiante(s) |
| **Estudiante** | Su registro de asistencia |

---

## 📅 Roadmap 2025-2026

```
DIC 30:  ✅ FASE 1 - Estructura Técnica
ENE 06:  ⏳ FASE 2 - Horarios y Justificaciones  
ENE 20:  ⏳ FASE 3 - Seguridad y Auditoría
FEB 03:  ⏳ FASE 4 - Reportes y Analytics
FEB 17:  ⏳ FASE 5 - API y Deployment
MAR 03:  ⏳ FASE 6 - UX/UI Final
```

---

## 🚀 Pasos para Usar

1. **Login:** http://127.0.0.1:8000/login
2. **Credenciales:** admin@example.com / password
3. **Dashboard:** Ver estadísticas en tiempo real
4. **Carreras:** Ir a "Carreras Técnicas" en menú
5. **Gestión:** Crear estudiantes, registrar asistencia

---

**Documento Oficial - ISTP Control v1.0**  
*Sistema profesional para institutos técnicos*
