<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('dashboard')
                ->with('error', 'No hay un perfil de estudiante asociado a este usuario.');
        }

        // Obtener asistencias del mes actual
        $currentMonth = Carbon::now();
        $attendances = Attendance::where('student_id', $student->id)
            ->whereYear('date', $currentMonth->year)
            ->whereMonth('date', $currentMonth->month)
            ->with(['courseAssignment.course', 'courseAssignment.teacher.user'])
            ->orderBy('date', 'desc')
            ->get()
            ->map(function($attendance) {
                return [
                    'id' => $attendance->id,
                    'date' => Carbon::parse($attendance->date)->format('d/m/Y'),
                    'time' => $attendance->time ? Carbon::parse($attendance->time)->format('H:i') : '—',
                    'status' => $attendance->status,
                    'course' => $attendance->courseAssignment->course->name ?? '—',
                    'teacher' => $attendance->courseAssignment->teacher->user->name ?? '—',
                    'notes' => $attendance->notes,
                ];
            });

        // Estadísticas del mes
        $stats = [
            'total' => $attendances->count(),
            'present' => $attendances->where('status', 'present')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'justified' => $attendances->where('status', 'justified')->count(),
        ];

        // Estadísticas generales (todo el tiempo)
        $allTimeStats = Attendance::where('student_id', $student->id)
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present,
                SUM(CASE WHEN status = "late" THEN 1 ELSE 0 END) as late,
                SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent,
                SUM(CASE WHEN status = "justified" THEN 1 ELSE 0 END) as justified
            ')
            ->first();

        // Últimas 5 asistencias
        $recentAttendances = Attendance::where('student_id', $student->id)
            ->with(['courseAssignment.course'])
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get()
            ->map(function($attendance) {
                return [
                    'date' => Carbon::parse($attendance->date)->format('d/m/Y'),
                    'time' => $attendance->time ? Carbon::parse($attendance->time)->format('H:i') : '—',
                    'status' => $attendance->status,
                    'course' => $attendance->courseAssignment->course->name ?? '—',
                ];
            });

        return Inertia::render('Student/Dashboard', [
            'student' => [
                'name' => $user->name,
                'dni' => $student->dni,
                'code' => $student->code,
                'email' => $student->email,
                'career' => $student->technicalCareer->name ?? 'Sin carrera',
            ],
            'monthStats' => $stats,
            'allTimeStats' => $allTimeStats,
            'recentAttendances' => $recentAttendances,
            'currentMonth' => $currentMonth->format('F Y'),
        ]);
    }

    public function myAttendances(Request $request)
    {
        $user = auth()->user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('dashboard');
        }

        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $status = $request->get('status');

        $query = Attendance::where('student_id', $student->id)
            ->with(['courseAssignment.course', 'courseAssignment.teacher.user']);

        if ($startDate) {
            $query->whereDate('date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('date', '<=', $endDate);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $attendances = $query->orderBy('date', 'desc')
            ->paginate(20)
            ->through(function($attendance) {
                return [
                    'id' => $attendance->id,
                    'date' => Carbon::parse($attendance->date)->format('d/m/Y'),
                    'time' => $attendance->time ? Carbon::parse($attendance->time)->format('H:i') : '—',
                    'status' => $attendance->status,
                    'course' => $attendance->courseAssignment->course->name ?? '—',
                    'teacher' => $attendance->courseAssignment->teacher->user->name ?? '—',
                    'notes' => $attendance->notes,
                ];
            });

        return Inertia::render('Student/MyAttendances', [
            'attendances' => $attendances,
            'filters' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => $status,
            ]
        ]);
    }
}
