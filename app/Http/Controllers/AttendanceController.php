<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function index()
    {
        // Obtener TODAS las asistencias con información del estudiante y carrera
        $attendances = Attendance::with(['student.user', 'student.technicalCareer'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($attendance) {
                $student = $attendance->student;
                
                return [
                    'id' => $attendance->id,
                    'student_name' => $student->user->name ?? 'Sin nombre',
                    'student_dni' => $student->dni ?? '—',
                    'student_code' => $student->code ?? '—',
                    'career' => $student->technicalCareer->name ?? 'Sin carrera',
                    'status' => $attendance->status,
                    'time' => $attendance->check_in_time 
                        ? \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i:s')
                        : '—',
                    'date' => $attendance->date 
                        ? \Carbon\Carbon::parse($attendance->date)->format('d/m/Y')
                        : '—',
                    'source' => $attendance->source ?? 'manual',
                    'device' => $attendance->device ?? '—',
                ];
            });

        // Estadísticas
        $today = \Carbon\Carbon::today();
        $todayAttendances = Attendance::whereDate('date', $today)->get();
        
        $stats = [
            'total' => $attendances->count(),
            'today' => $todayAttendances->count(),
            'present' => $todayAttendances->where('status', 'present')->count(),
            'late' => $todayAttendances->where('status', 'late')->count(),
            'absent' => $todayAttendances->where('status', 'absent')->count(),
        ];

        return Inertia::render('Attendance/Index', [
            'attendances' => $attendances,
            'stats' => $stats
        ]);
    }

    public function register()
    {
        // Obtener todas las carreras y ciclos para los filtros
        $careers = \App\Models\TechnicalCareer::select('id', 'name', 'code')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return Inertia::render('Attendance/Register', [
            'careers' => $careers
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'career_id' => 'required|exists:technical_careers,id',
            'semester' => 'required|integer|min:1|max:6',
            'date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*.student_id' => 'required|exists:students,id',
            'attendances.*.status' => 'required|in:present,absent,late,justified',
        ]);

        $created = 0;
        $updated = 0;

        foreach ($data['attendances'] as $attendanceData) {
            // Verificar si ya existe registro para este estudiante en esta fecha
            $existing = Attendance::where('student_id', $attendanceData['student_id'])
                ->whereDate('date', $data['date'])
                ->first();

            if ($existing) {
                // Actualizar
                $existing->update([
                    'status' => $attendanceData['status'],
                    'registered_by' => auth()->id(),
                    'notes' => 'Actualizado por ' . auth()->user()->name,
                ]);
                $updated++;
            } else {
                // Crear nuevo
                Attendance::create([
                    'student_id' => $attendanceData['student_id'],
                    'course_assignment_id' => null,
                    'date' => $data['date'],
                    'time' => now()->format('H:i:s'),
                    'status' => $attendanceData['status'],
                    'registered_by' => auth()->id(),
                    'notes' => 'Registrado por ' . auth()->user()->name,
                    'attendance_source' => 'manual',
                    'location' => 'Sistema Web',
                    'device_token' => null,
                ]);
                $created++;
            }
        }

        return redirect()->route('attendance.register')->with('success', "Asistencia guardada: {$created} nuevos, {$updated} actualizados");
    }
}
