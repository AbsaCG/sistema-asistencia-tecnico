<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\TechnicalCareer;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        // Total estudiantes
        $totalStudents = Student::count();
        
        // Asistencias de hoy
        $attendancesToday = Attendance::whereDate('date', $today)->count();
        $presentToday = Attendance::whereDate('date', $today)
            ->where('status', 'present')
            ->count();
        $absentToday = Attendance::whereDate('date', $today)
            ->where('status', 'absent')
            ->count();
        $lateToday = Attendance::whereDate('date', $today)
            ->where('status', 'late')
            ->count();
        
        // Calcular porcentaje
        $attendancePercentage = $totalStudents > 0 
            ? round(($presentToday / $totalStudents) * 100, 1)
            : 0;
        
        // Total carreras técnicas
        $totalCareers = TechnicalCareer::count();
        
        // Justificaciones pendientes (placeholder)
        $pendingJustifications = 3;
        
        // Actividad reciente (últimos 10 registros de asistencia de hoy)
        $recentActivity = Attendance::with(['student.user', 'student.technicalCareer'])
            ->whereDate('created_at', $today)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function($a) {
                $studentName = $a->student?->user?->name ?? 'Desconocido';
                $dni = $a->student?->dni ?? '—';
                $career = $a->student?->technicalCareer?->name ?? '—';
                
                return [
                    'id' => $a->id,
                    'student_name' => $studentName,
                    'action' => $a->status === 'present' 
                        ? "✓ Asistencia registrada • DNI: {$dni}" 
                        : ($a->status === 'absent' ? 'Ausente' : 'Tarde'),
                    'timestamp' => $a->created_at->toISOString(),
                    'type' => $a->status,
                ];
            });
        
        // Datos para gráficos - Asistencias de los últimos 7 días
        $last7Days = [];
        $attendanceByDay = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $last7Days[] = $date->format('d M');
            
            $dayData = Attendance::whereDate('date', $date)
                ->selectRaw("
                    COUNT(CASE WHEN status = 'present' THEN 1 END) as present,
                    COUNT(CASE WHEN status = 'absent' THEN 1 END) as absent,
                    COUNT(CASE WHEN status = 'late' THEN 1 END) as late
                ")
                ->first();
            
            $attendanceByDay[] = [
                'present' => $dayData->present ?? 0,
                'absent' => $dayData->absent ?? 0,
                'late' => $dayData->late ?? 0,
            ];
        }
        
        // Asistencias por carrera técnica
        $attendanceByCareer = TechnicalCareer::withCount(['students as present_count' => function($query) use ($today) {
            $query->whereHas('attendances', function($q) use ($today) {
                $q->whereDate('date', $today)->where('status', 'present');
            });
        }])
        ->withCount(['students as total_students'])
        ->get()
        ->map(function($career) {
            return [
                'name' => $career->name,
                'present' => $career->present_count ?? 0,
                'total' => $career->total_students ?? 0,
            ];
        });
        
        return Inertia::render('Dashboard/Index', [
            'stats' => [
                'totalStudents' => $totalStudents,
                'presentToday' => $presentToday,
                'absentToday' => $absentToday,
                'lateToday' => $lateToday,
                'attendancePercentage' => $attendancePercentage,
                'totalCareers' => $totalCareers,
                'attendancesToday' => $attendancesToday,
            ],
            'pendingJustifications' => $pendingJustifications,
            'recentActivity' => $recentActivity,
            'chartData' => [
                'last7Days' => $last7Days,
                'attendanceByDay' => $attendanceByDay,
                'attendanceByCareer' => $attendanceByCareer,
            ],
        ]);
    }
}
