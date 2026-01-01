<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Forzar HTTPS en producción
        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Definir Gates para permisos
        
        // Super Admin - Control total
        Gate::define('manage-system', function (User $user) {
            return $user->hasRole('admin');
        });

        // Gestión de usuarios
        Gate::define('manage-users', function (User $user) {
            return $user->hasRole('admin');
        });

        // Gestión de estudiantes
        Gate::define('manage-students', function (User $user) {
            return $user->hasAnyRole(['admin', 'teacher']);
        });

        // Gestión de docentes
        Gate::define('manage-teachers', function (User $user) {
            return $user->hasRole('admin');
        });

        // Gestión de cursos
        Gate::define('manage-courses', function (User $user) {
            return $user->hasAnyRole(['admin', 'teacher']);
        });

        // Gestión de horarios
        Gate::define('manage-schedules', function (User $user) {
            return $user->hasAnyRole(['admin', 'teacher']);
        });

        // Registro de asistencia
        Gate::define('register-attendance', function (User $user) {
            return $user->hasAnyRole(['admin', 'teacher', 'staff']);
        });

        // Ver asistencia (todos pueden ver la suya)
        Gate::define('view-attendance', function (User $user) {
            return true; // Todos pueden ver su propia asistencia
        });

        // Ver todas las asistencias
        Gate::define('view-all-attendances', function (User $user) {
            return $user->hasAnyRole(['admin', 'teacher', 'staff']);
        });

        // Gestionar justificaciones
        Gate::define('manage-justifications', function (User $user) {
            return $user->hasAnyRole(['admin', 'teacher']);
        });

        // Crear justificaciones (estudiantes pueden crear las suyas)
        Gate::define('create-justification', function (User $user) {
            return true; // Todos pueden crear justificaciones
        });

        // Ver reportes
        Gate::define('view-reports', function (User $user) {
            return $user->hasAnyRole(['admin', 'teacher', 'staff']);
        });

        // Configuración del sistema
        Gate::define('manage-settings', function (User $user) {
            return $user->hasRole('admin');
        });

        // Ver logs del sistema
        Gate::define('view-logs', function (User $user) {
            return $user->hasRole('admin');
        });
    }
}
