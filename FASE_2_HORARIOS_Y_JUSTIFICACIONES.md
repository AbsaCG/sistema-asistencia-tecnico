# 🎓 FASE 2: HORARIOS Y JUSTIFICACIONES DE INASISTENCIA
## ISTP Control - Sistema de Gestión de Asistencia

**Fecha:** 30 de Diciembre de 2025  
**Estado:** Análisis y Diseño Completo  
**Responsable:** Sistema ISTP Control

---

## 📋 Cambios Completados en FASE 1+

### ✅ Relación Estudiante-Carrera Técnica
- ✅ Migración creada: `2025_12_30_000014_add_technical_career_to_students.php`
- ✅ Columna `technical_career_id` agregada a tabla `students`
- ✅ Relación `technicalCareer()` en modelo Student
- ✅ Campo actualizado en fillable array

### ✅ Actualización UI - Estudiantes
- ✅ Tabla de estudiantes ahora muestra **Carrera Técnica** con badge
- ✅ Agregada columna **Semestre** (1-4)
- ✅ Filtros actualizados a "Todas las Carreras" en lugar de "Grados"
- ✅ Formulario de creación incluye selector de **Carrera Técnica**
- ✅ Assets reconstruidos (**3.92s**)

### 📊 Datos de Ejemplo Actualizados
```
EST001 | Juan Pérez        | PA-2024 | Semestre 1 | Activo
EST002 | María García      | CONT-2024 | Semestre 2 | Activo
EST003 | Carlos López      | DEVSW-2024 | Semestre 1 | Inactivo
EST004 | Ana Rodríguez     | GAST-2024 | Semestre 3 | Activo
EST005 | Pedro Mendoza     | ENFER-2024 | Semestre 2 | Activo
```

---

## 🎯 FASE 2: Planificación Detallada

### 1️⃣ HORARIOS Y BLOQUES DE CLASE (Weeks 1-2)

#### Base de Datos

**Nueva tabla: `class_schedules`**
```sql
CREATE TABLE class_schedules (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    technical_career_id BIGINT NOT NULL,
    course_id BIGINT NOT NULL,
    teacher_id BIGINT NOT NULL,
    day_of_week ENUM('lunes','martes','miércoles','jueves','viernes','sábado'),
    start_time TIME,
    end_time TIME,
    classroom VARCHAR(50),
    block_number INT (1-5),
    capacity INT,
    semester INT (1-4),
    is_active BOOLEAN,
    observations TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (technical_career_id) REFERENCES technical_careers(id),
    FOREIGN KEY (course_id) REFERENCES courses(id),
    FOREIGN KEY (teacher_id) REFERENCES teachers(id)
);
```

**Nueva tabla: `attendance_blocks`**
```sql
CREATE TABLE attendance_blocks (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    class_schedule_id BIGINT NOT NULL,
    date DATE,
    block_status ENUM('scheduled','in_progress','completed','cancelled'),
    attendance_taken_at TIMESTAMP NULL,
    attendance_taken_by BIGINT,
    notes TEXT,
    created_at TIMESTAMP,
    
    FOREIGN KEY (class_schedule_id) REFERENCES class_schedules(id),
    FOREIGN KEY (attendance_taken_by) REFERENCES users(id)
);
```

#### Modelos Laravel
```php
// app/Models/ClassSchedule.php
class ClassSchedule extends Model {
    protected $fillable = ['technical_career_id', 'course_id', 'teacher_id', 
                          'day_of_week', 'start_time', 'end_time', 'classroom', 
                          'block_number', 'capacity', 'semester', 'is_active'];
    
    public function technicalCareer() { return $this->belongsTo(TechnicalCareer::class); }
    public function course() { return $this->belongsTo(Course::class); }
    public function teacher() { return $this->belongsTo(Teacher::class); }
    public function attendanceBlocks() { return $this->hasMany(AttendanceBlock::class); }
}

// app/Models/AttendanceBlock.php
class AttendanceBlock extends Model {
    protected $fillable = ['class_schedule_id', 'date', 'block_status', 
                          'attendance_taken_at', 'attendance_taken_by', 'notes'];
    
    public function classSchedule() { return $this->belongsTo(ClassSchedule::class); }
    public function attendances() { return $this->hasMany(Attendance::class); }
}
```

#### Interfaz UI
- **Admin**: Página de Horarios por Carrera
  - Vista tabla: Día, Hora, Curso, Profesor, Aula, Bloque
  - Botón: + Agregar Horario
  - Filtro: Por carrera, semestre, día
  
- **Profesor**: Mis Horarios
  - Vista en bloques por día
  - Botón: "Tomar Asistencia" en cada bloque
  - Resumen: Total bloques, bloques con asistencia

- **Sistema**: Auto-generador de bloques
  - Config: Lunes-Viernes 5 bloques diarios
  - Horas: 8:00-8:45, 8:45-9:30, 10:00-10:45, 10:45-11:30, 12:30-13:15
  - Aulas: Automático (A101, A102, etc.)

---

### 2️⃣ JUSTIFICACIONES DE INASISTENCIA (Weeks 3-4)

#### Base de Datos

**Nueva tabla: `attendance_justifications`**
```sql
CREATE TABLE attendance_justifications (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    student_id BIGINT NOT NULL,
    attendance_id BIGINT NOT NULL,
    justification_type ENUM('enfermedad','familiar','trabajo','documentación','otra'),
    description TEXT,
    document_path VARCHAR(255) NULL,
    request_date DATETIME,
    request_status ENUM('pendiente','aprobada','rechazada','en_revision'),
    approved_by BIGINT NULL,
    approved_at DATETIME NULL,
    final_approved_by BIGINT NULL (coordinador),
    final_approved_at DATETIME NULL,
    rejection_reason TEXT NULL,
    created_at TIMESTAMP,
    
    FOREIGN KEY (student_id) REFERENCES students(id),
    FOREIGN KEY (attendance_id) REFERENCES attendances(id),
    FOREIGN KEY (approved_by) REFERENCES users(id),
    FOREIGN KEY (final_approved_by) REFERENCES users(id)
);

CREATE INDEX idx_student_status ON attendance_justifications(student_id, request_status);
CREATE INDEX idx_approval_pending ON attendance_justifications(request_status, approved_by);
```

**Modificar tabla: `attendances`**
```sql
ALTER TABLE attendances ADD COLUMN is_justified BOOLEAN DEFAULT FALSE;
ALTER TABLE attendances ADD COLUMN justification_id BIGINT NULL;
ALTER TABLE attendances ADD FOREIGN KEY (justification_id) REFERENCES attendance_justifications(id);
```

#### Flujo de Aprobación
```
1. ESTUDIANTE SOLICITA
   └─ Completa formulario: tipo, descripción, carga documento (PDF/imagen)
   └─ Estado: "pendiente"

2. PROFESOR REVISA (24 horas)
   ├─ Aprueba → Estado: "en_revision"
   └─ Rechaza → Estado: "rechazada" + motivo

3. COORDINADOR APRUEBA (48 horas)
   ├─ Aprueba → Estado: "aprobada" + marca asistencia
   └─ Rechaza → Estado: "rechazada" + motivo

4. SISTEMA VALIDA
   └─ Si >= 1 justificación aprobada, no cuenta inasistencia
   └─ Si rechazada, cuenta como inasistencia
```

#### Modelos Laravel
```php
// app/Models/AttendanceJustification.php
class AttendanceJustification extends Model {
    protected $fillable = ['student_id', 'attendance_id', 'justification_type', 
                          'description', 'document_path', 'request_status'];
    
    public function student() { return $this->belongsTo(Student::class); }
    public function attendance() { return $this->belongsTo(Attendance::class); }
    public function approvedBy() { return $this->belongsTo(User::class, 'approved_by'); }
    public function finalApprovedBy() { return $this->belongsTo(User::class, 'final_approved_by'); }
    
    public function approve() { 
        $this->update(['request_status' => 'en_revision', 'approved_by' => auth()->id()]); 
    }
    
    public function finalApprove() { 
        $this->update(['request_status' => 'aprobada', 'final_approved_by' => auth()->id()]);
        $this->attendance->update(['is_justified' => true]);
    }
}
```

#### Interfaz UI
- **Estudiante**: Formulario de Justificación
  - Tipo: Dropdown (enfermedad, familiar, trabajo, documentación)
  - Descripción: Textarea 200 caracteres
  - Documento: File upload (PDF, JPG, PNG máx 5MB)
  - Botón: Enviar Justificación
  
- **Profesor**: Panel de Justificaciones Pendientes
  - Tabla: Estudiante, Fecha, Tipo, Estado, Acciones
  - Acciones: Ver documento, Aprobar, Rechazar
  
- **Coordinador**: Dashboard de Aprobaciones
  - Métricas: Total solicitudes, pendientes, aprobadas, rechazadas
  - Tabla: Estudiante, Carrera, Tipo, Profesor recomendación, Estado
  - Acciones: Aprobar, Rechazar, Ver documento
  
- **Estudiante**: Estado de Justificaciones
  - Historial: Fecha, Tipo, Estado, Motivo (si rechazada)
  - Notificación: Email cuando es aprobada/rechazada

---

### 3️⃣ VALIDACIÓN DE ASISTENCIA (Criterios)

**Regla 1: Porcentaje Mínimo de Asistencia**
```php
// 80% asistencia requerida
protected $minimumAttendancePercentage = 80;

public function getAttendancePercentage() {
    $totalClasses = $this->attendances()->count();
    $justifiedAbsences = $this->attendances()
        ->where('status', 'absent')
        ->whereHas('justification', fn($q) => $q->where('request_status', 'aprobada'))
        ->count();
    
    $present = $this->attendances()->where('status', 'present')->count();
    $counting = $present + $justifiedAbsences;
    
    return ($counting / $totalClasses) * 100;
}

public function meetsMinimumAttendance() {
    return $this->getAttendancePercentage() >= $this->minimumAttendancePercentage;
}
```

**Regla 2: Inasistencia Injustificada**
```php
public function getUnjustifiedAbsences() {
    return $this->attendances()
        ->where('status', 'absent')
        ->whereDoesntHave('justification', fn($q) => $q->where('request_status', 'aprobada'))
        ->count();
}

public function isAtRisk() {
    $percentage = $this->getAttendancePercentage();
    return $percentage >= 70 && $percentage < 80; // Zona de riesgo
}
```

**Regla 3: Condicionalidad**
```php
public function getStudentStatus() {
    $percentage = $this->getAttendancePercentage();
    
    if ($percentage >= 80) return 'REGULAR'; // Aprobado en asistencia
    if ($percentage >= 70) return 'EN_RIESGO'; // Zona gris
    if ($percentage >= 60) return 'CONDICIONAL'; // Debe mejorar
    return 'DESCALIFICADO'; // Perdió el semestre
}
```

---

## 📅 Implementación Timeline

### Semana 1 (31 Dec - 5 Jan)
```
[ ] Crear migrations para class_schedules y attendance_blocks
[ ] Crear modelos ClassSchedule y AttendanceBlock
[ ] Crear seeder ClassScheduleSeeder con 30 horarios ejemplo
[ ] Crear CRUD de Horarios (AdminController)
[ ] Crear UI: Pages/Academic/Schedules/Index.vue
[ ] Tests unitarios para modelo ClassSchedule
```

### Semana 2 (6-12 Jan)
```
[ ] UI: Profesor visualizar sus horarios
[ ] UI: Tomar asistencia por bloque
[ ] Sistema auto-generar bloques por carrera
[ ] Validaciones: No duplicar horarios, capacidad aulas
[ ] Tests de integración horarios
```

### Semana 3 (13-19 Jan)
```
[ ] Crear migrations para attendance_justifications
[ ] Crear modelo AttendanceJustification
[ ] Crear seeder con 50 justificaciones ejemplo
[ ] Crear CRUD de Justificaciones (StudentController)
[ ] UI: Estudiante solicitar justificación
[ ] Sistema de almacenamiento de documentos
```

### Semana 4 (20-26 Jan)
```
[ ] UI: Profesor revisar justificaciones
[ ] UI: Coordinador aprobar finales
[ ] Sistema de notificaciones (email)
[ ] Validación automática de asistencia >= 80%
[ ] Tests completos del flujo
[ ] Reportes por carrera y estudiante
```

---

## 🏗️ Estructura de Directorios (Nueva)

```
app/
├── Http/
│   └── Controllers/
│       ├── ScheduleController.php (NEW)
│       └── JustificationController.php (NEW)
├── Models/
│   ├── ClassSchedule.php (NEW)
│   ├── AttendanceBlock.php (NEW)
│   └── AttendanceJustification.php (UPDATED)
└── Notifications/
    ├── JustificationApprovedNotification.php (NEW)
    └── JustificationRejectedNotification.php (NEW)

resources/js/Pages/
├── Academic/
│   └── Schedules/
│       ├── Index.vue (NEW)
│       └── Create.vue (NEW)
├── Justifications/
│   ├── StudentRequest.vue (NEW)
│   ├── ProfessorReview.vue (NEW)
│   └── CoordinatorApprove.vue (NEW)
└── ...

database/migrations/
├── 2025_12_31_000015_create_class_schedules_table.php (NEW)
├── 2025_12_31_000016_create_attendance_blocks_table.php (NEW)
├── 2025_12_31_000017_create_attendance_justifications_table.php (NEW)
└── 2025_12_31_000018_modify_attendances_table.php (NEW)
```

---

## 🔐 Permisos Requeridos

```php
// Permisos nuevos a crear
'schedule.view'       // Ver horarios
'schedule.create'     // Crear horarios
'schedule.edit'       // Editar horarios
'schedule.delete'     // Eliminar horarios
'justification.view'  // Ver justificaciones
'justification.request' // Solicitar justificación
'justification.approve' // Aprobar (profesor)
'justification.final_approve' // Aprobar final (coordinador)

// Asignación por rol
ADMIN: Todos
TEACHER: schedule.view, justification.approve
COORDINATOR: schedule.view, justification.final_approve
STUDENT: schedule.view, justification.request, justification.view
```

---

## 📊 Reportes Generados

### Para Coordinador
- **Asistencia Diaria**: CSV con presentes/ausentes por carrera
- **Justificaciones Pendientes**: Listado para aprobación
- **Estudiantes en Riesgo**: Quiénes están bajo 80% asistencia
- **Estadísticas Carrera**: Promedio asistencia por carrera

### Para Profesor
- **Asistencia Bloque**: Confirmación de registro
- **Mis Estudiantes Inasistentes**: Para seguimiento

### Para Estudiante
- **Mi Asistencia**: Porcentaje, bloques presentes/ausentes
- **Estado**: Regular / En Riesgo / Condicional / Descalificado
- **Justificaciones**: Historial con estados

---

## 💾 Scripts de Seed Ejemplo

```php
// database/seeders/ClassScheduleSeeder.php
public function run() {
    $careers = TechnicalCareer::all();
    $teachers = Teacher::all()->random(10);
    $courses = Course::all();
    
    $days = ['lunes', 'martes', 'miércoles', 'jueves', 'viernes'];
    $times = [
        ['08:00', '08:45'],
        ['08:45', '09:30'],
        ['10:00', '10:45'],
        ['10:45', '11:30'],
        ['12:30', '13:15'],
    ];
    
    foreach ($careers as $career) {
        foreach ($days as $day) {
            foreach ($times as $index => $time) {
                ClassSchedule::create([
                    'technical_career_id' => $career->id,
                    'course_id' => $courses->random()->id,
                    'teacher_id' => $teachers->random()->id,
                    'day_of_week' => $day,
                    'start_time' => $time[0],
                    'end_time' => $time[1],
                    'classroom' => 'A' . (100 + rand(1, 20)),
                    'block_number' => $index + 1,
                    'capacity' => 40,
                    'semester' => rand(1, 4),
                    'is_active' => true,
                ]);
            }
        }
    }
}
```

---

## 🚀 Siguientes Pasos

1. **Verificar conexión MySQL** está activa
2. **Ejecutar migración** `2025_12_30_000014_add_technical_career_to_students.php`
3. **Probar creación estudiante** con carrera técnica
4. **Iniciar FASE 2** con creación de migrations de horarios

---

**Documento FASE 2 - ISTP Control**  
*Diseño e implementación de Horarios y Justificaciones*
