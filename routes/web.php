<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\GateController;
use App\Http\Controllers\Api\GateController as ApiGateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AttendanceRegisterController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CourseController;
use Inertia\Inertia;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Auth Routes
Route::get('/login', [LoginController::class, 'create'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'store'])->middleware('guest');
Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

// Public Landing Page (Attendance Registration)
Route::get('/', [AttendanceRegisterController::class, 'index'])->name('landing');

// TEST AUTH ROUTE
Route::get('/test-auth', function() {
    return Inertia::render('TestAuth');
})->middleware('auth');

// Public API endpoint for landing page attendance (no CSRF) - Moved to api.php
// Route::post('/api/attendance/register', [AttendanceRegisterController::class, 'register']);

// DEBUG: Ver DNIs disponibles
Route::get('/debug/dnis', function() {
    $students = \App\Models\Student::select('id', 'dni', 'email')->limit(20)->get();
    
    // Mostrar cada DNI con detalles
    $detailed = $students->map(function($s) {
        return [
            'id' => $s->id,
            'dni' => $s->dni,
            'dni_length' => strlen($s->dni),
            'dni_hex' => bin2hex($s->dni),
            'dni_trimmed' => trim($s->dni),
            'dni_trimmed_length' => strlen(trim($s->dni)),
            'email' => $s->email,
        ];
    });
    
    return response()->json([
        'count' => $students->count(),
        'students' => $detailed,
    ]);
});

// DEBUG: Probar búsqueda de DNI específico
Route::get('/debug/search/{dni}', function($dni) {
    \Log::info("DEBUG: Buscando DNI: '$dni'");
    
    $student = \App\Models\Student::where('dni', $dni)->first();
    
    return response()->json([
        'input_dni' => $dni,
        'input_dni_length' => strlen($dni),
        'input_dni_hex' => bin2hex($dni),
        'found' => $student ? true : false,
        'student' => $student,
        'sql' => "SELECT * FROM students WHERE dni = '$dni'",
        'all_dnis' => \App\Models\Student::select('dni')->limit(5)->pluck('dni')->toArray(),
    ]);
});

// DEBUG: Probar el endpoint de registro con POST
Route::get('/debug/register/{dni}', function(\Illuminate\Http\Request $request, $dni) {
    $dni_raw = $dni;
    $dni = trim($dni_raw);
    
    // Debug detallado
    $debug = [
        'dni_raw' => $dni_raw,
        'dni_raw_length' => strlen($dni_raw),
        'dni_raw_hex' => bin2hex($dni_raw),
        'dni_trimmed' => $dni,
        'dni_trimmed_length' => strlen($dni),
        'dni_trimmed_hex' => bin2hex($dni),
    ];
    
    $student = \App\Models\Student::with('technicalCareer', 'user')
        ->where('dni', $dni)
        ->first();
    
    $debug['student_found'] = $student ? true : false;
    
    if (!$student) {
        $debug['tried_queries'] = [
            'Query 1 (con trim)' => "SELECT * FROM students WHERE dni = '$dni'",
            'Query 2 (sin trim)' => "SELECT * FROM students WHERE dni = '$dni_raw'",
            'Todos los DNIs en BD' => \App\Models\Student::select('dni')->limit(10)->pluck('dni')->toArray(),
        ];
        
        return response()->json($debug, 404);
    }
    
    return response()->json([
        'success' => true,
        'debug' => $debug,
        'student' => [
            'id' => $student->id,
            'name' => $student->user->name ?? 'Desconocido',
            'dni' => $student->dni,
            'email' => $student->email,
        ],
    ]);
});

// Public API endpoint for gate devices (no CSRF)
Route::post('/api/attendance/gate', [ApiGateController::class, 'register'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

Route::middleware(['auth'])->group(function () {
    // Dashboard - Dinámico según rol
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Student Portal - Solo estudiantes
    Route::prefix('/student')->name('student.')->middleware('role:student')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Student\StudentDashboardController::class, 'index'])->name('dashboard');
        Route::get('/my-attendances', [\App\Http\Controllers\Student\StudentDashboardController::class, 'myAttendances'])->name('my-attendances');
        Route::get('/profile', [\App\Http\Controllers\Student\StudentProfileController::class, 'index'])->name('profile');
        Route::get('/attendance', [\App\Http\Controllers\Student\StudentAttendanceController::class, 'index'])->name('attendance');
        Route::get('/schedule', [\App\Http\Controllers\Student\StudentScheduleViewController::class, 'index'])->name('schedule');
        Route::get('/justifications', [\App\Http\Controllers\Student\StudentJustificationViewController::class, 'index'])->name('justifications');
        Route::post('/justifications', [\App\Http\Controllers\Student\StudentJustificationViewController::class, 'store'])->name('justifications.store');
        Route::get('/notifications', function () {
            return Inertia::render('Student/Notifications');
        })->name('notifications');
    });

    // Academic Management - Solo admin
    Route::prefix('/academic')->name('academic.')->middleware('role:admin')->group(function () {
        Route::get('/faculties', function () {
            return Inertia::render('Academic/Faculties/Index');
        })->name('faculties.index');

        Route::get('/careers', function () {
            return Inertia::render('Academic/Careers/Index');
        })->name('careers.index');

        Route::get('/years', function () {
            return Inertia::render('Academic/Years/Index');
        })->name('years.index');
        
        Route::get('/periods', function () {
            return Inertia::render('Academic/Periods/Index');
        })->name('periods.index');

        // Horarios (FASE 2)
        Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');
        Route::get('/schedules/create', [ScheduleController::class, 'create'])->name('schedules.create');
        Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedules.store');

        // Gate quick-check (DNI)
        Route::get('/attendance/gate', [GateController::class, 'index'])->name('attendance.gate');
        Route::post('/attendance/gate/check', [GateController::class, 'check'])->name('attendance.gate.check');
    });

    // Import System - Solo admin
    Route::prefix('/import')->name('import.')->middleware('role:admin')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ImportController::class, 'index'])->name('index');
        Route::post('/students', [\App\Http\Controllers\Admin\ImportController::class, 'importStudents'])->name('students');
        Route::get('/template', [\App\Http\Controllers\Admin\ImportController::class, 'downloadTemplate'])->name('template');
    });

    // Student Portal (estudiantes autenticados) - LEGACY (mantener por compatibilidad)
    Route::prefix('/student')->name('student.')->middleware('role:student')->group(function () {
        Route::get('/profile', [\App\Http\Controllers\Student\StudentProfileController::class, 'index'])->name('profile');
        Route::get('/attendance', [\App\Http\Controllers\Student\StudentAttendanceController::class, 'index'])->name('attendance');
        Route::get('/schedule', [\App\Http\Controllers\Student\StudentScheduleViewController::class, 'index'])->name('schedule');
        Route::get('/justifications', [\App\Http\Controllers\Student\StudentJustificationViewController::class, 'index'])->name('justifications');
        Route::post('/justifications', [\App\Http\Controllers\Student\StudentJustificationViewController::class, 'store'])->name('justifications.store');
        Route::get('/notifications', function () {
            return Inertia::render('Student/Notifications');
        })->name('notifications');
    });

    // Students Management (admin and teachers)
    Route::prefix('/students')->name('students.')->middleware('role:admin,teacher')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('index');
        Route::get('/create', [StudentController::class, 'create'])->name('create');
        Route::post('/', [StudentController::class, 'store'])->name('store');
        Route::get('/{student}', [StudentController::class, 'show'])->name('show');
        Route::get('/{student}/edit', [StudentController::class, 'edit'])->name('edit');
        Route::put('/{student}', [StudentController::class, 'update'])->name('update');
        Route::delete('/{student}', [StudentController::class, 'destroy'])->name('destroy');
    });

    // Teachers Management (admin only)
    Route::prefix('/teachers')->name('teachers.')->middleware('role:admin')->group(function () {
        Route::get('/', [TeacherController::class, 'index'])->name('index');
        Route::get('/create', [TeacherController::class, 'create'])->name('create');
        Route::post('/', [TeacherController::class, 'store'])->name('store');
        Route::get('/{teacher}', [TeacherController::class, 'show'])->name('show');
        Route::get('/{teacher}/edit', [TeacherController::class, 'edit'])->name('edit');
        Route::put('/{teacher}', [TeacherController::class, 'update'])->name('update');
        Route::delete('/{teacher}', [TeacherController::class, 'destroy'])->name('destroy');
    });

    // Courses Management (admin and teachers)
    Route::prefix('/courses')->name('courses.')->middleware('role:admin,teacher')->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('index');
        Route::get('/create', [CourseController::class, 'create'])->name('create');
        Route::post('/', [CourseController::class, 'store'])->name('store');
        Route::get('/{course}', [CourseController::class, 'show'])->name('show');
        Route::get('/{course}/edit', [CourseController::class, 'edit'])->name('edit');
        Route::put('/{course}', [CourseController::class, 'update'])->name('update');
        Route::delete('/{course}', [CourseController::class, 'destroy'])->name('destroy');
    });

    // Justifications Management (admin and teachers)
    Route::prefix('/justifications')->name('justifications.')->middleware('role:admin,teacher')->group(function () {
        Route::get('/', function () {
            return Inertia::render('Justifications/Index');
        })->name('index');
        
        Route::put('/{id}/review', function ($id) {
            // Implementar lógica de revisión
            return redirect()->back()->with('success', 'Justificación revisada');
        })->name('review');
    });

    // Notifications
    Route::prefix('/notifications')->name('notifications.')->middleware('role:admin,teacher')->group(function () {
        Route::get('/', function () {
            return Inertia::render('Notifications/Index');
        })->name('index');
    });

    // Users Management (admin only)
    Route::prefix('/users')->name('users.')->middleware('role:admin')->group(function () {
        Route::get('/', function () {
            return Inertia::render('Users/Index');
        })->name('index');
    });

    // System Logs (admin only)
    Route::prefix('/logs')->name('logs.')->middleware('role:admin')->group(function () {
        Route::get('/', function () {
            return Inertia::render('Logs/Index');
        })->name('index');
    });

    // Attendance Management (admin, teachers, staff)
    Route::prefix('/attendance')->name('attendance.')->middleware('role:admin,teacher,staff')->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('index');
        
        Route::get('/register', [AttendanceController::class, 'register'])->name('register');
        Route::post('/register', [AttendanceController::class, 'store'])->name('store');
    });

    // Reports (admin, teachers, staff)
    Route::prefix('/reports')->name('reports.')->middleware('role:admin,teacher,staff')->group(function () {
        Route::get('/attendance', [ReportController::class, 'attendance'])->name('attendance');
        Route::get('/attendance/download/pdf', [ReportController::class, 'downloadPdf'])->name('attendance.pdf');
        Route::get('/attendance/download/excel', [ReportController::class, 'downloadExcel'])->name('attendance.excel');
        
        Route::get('/statistics', function () {
            return Inertia::render('Reports/Statistics');
        })->name('statistics');
    });

    // Settings (admin only)
    Route::prefix('/settings')->name('settings.')->middleware('role:admin')->group(function () {
        Route::get('/system', function () {
            return Inertia::render('Settings/System');
        })->name('system');

        // Roles & Permissions management
        Route::get('/roles', [\App\Http\Controllers\Admin\RoleController::class, 'index'])->name('roles.index');
        Route::post('/roles', [\App\Http\Controllers\Admin\RoleController::class, 'store'])->name('roles.store');
        Route::put('/roles/{role}', [\App\Http\Controllers\Admin\RoleController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{role}', [\App\Http\Controllers\Admin\RoleController::class, 'destroy'])->name('roles.destroy');
    });
});
