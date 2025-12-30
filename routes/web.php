<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Auth Routes
Route::get('/login', [LoginController::class, 'create'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'store'])->middleware('guest');
Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::get('/', function () {
    return auth()->check() ? redirect('/dashboard') : redirect('/login');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard/Index');
    })->name('dashboard');

    // Academic Management
    Route::prefix('/academic')->name('academic.')->middleware('role:admin')->group(function () {
        Route::get('/years', function () {
            return Inertia::render('Academic/Years/Index');
        })->name('years.index');
        
        Route::get('/periods', function () {
            return Inertia::render('Academic/Periods/Index');
        })->name('periods.index');
    });

    // Students Management (admin and teachers)
    Route::prefix('/students')->name('students.')->middleware('role:admin,teacher')->group(function () {
        Route::get('/', function () {
            return Inertia::render('Students/Index');
        })->name('index');
        
        Route::get('/create', function () {
            return Inertia::render('Students/Create');
        })->name('create');
    });

    // Teachers Management (admin only)
    Route::prefix('/teachers')->name('teachers.')->middleware('role:admin')->group(function () {
        Route::get('/', function () {
            return Inertia::render('Teachers/Index');
        })->name('index');
        
        Route::get('/create', function () {
            return Inertia::render('Teachers/Create');
        })->name('create');
    });

    // Attendance Management (admin and teachers)
    Route::prefix('/attendance')->name('attendance.')->middleware('role:admin,teacher')->group(function () {
        Route::get('/', function () {
            return Inertia::render('Attendance/Index');
        })->name('index');
        
        Route::get('/register', function () {
            return Inertia::render('Attendance/Register');
        })->name('register');
    });

    // Reports
    Route::prefix('/reports')->name('reports.')->group(function () {
        Route::get('/attendance', function () {
            return Inertia::render('Reports/AttendanceReport');
        })->name('attendance');
        
        Route::get('/statistics', function () {
            return Inertia::render('Reports/Statistics');
        })->name('statistics');
    });

    // Settings (admin only)
    Route::prefix('/settings')->name('settings.')->middleware('role:admin')->group(function () {
        Route::get('/system', function () {
            return Inertia::render('Settings/System');
        })->name('system');
    });
});
