<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Attendance;

class StudentAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $student = $user->student;

        if (!$student) {
            return redirect('/dashboard')->with('error', 'No se encontró información del estudiante');
        }

        // Obtener asistencias del estudiante
        $attendances = Attendance::where('student_id', $student->id)
            ->with(['courseAssignment.course', 'courseAssignment.teacher.user'])
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->paginate(20);

        // Calcular estadísticas
        $totalAttendances = Attendance::where('student_id', $student->id)->count();
        $presentCount = Attendance::where('student_id', $student->id)
            ->where('status', 'present')
            ->count();
        $absentCount = Attendance::where('student_id', $student->id)
            ->where('status', 'absent')
            ->count();
        $lateCount = Attendance::where('student_id', $student->id)
            ->where('status', 'late')
            ->count();

        $attendancePercentage = $totalAttendances > 0 
            ? round(($presentCount / $totalAttendances) * 100, 1) 
            : 0;

        return Inertia::render('Student/Attendance', [
            'attendances' => $attendances,
            'stats' => [
                'total' => $totalAttendances,
                'present' => $presentCount,
                'absent' => $absentCount,
                'late' => $lateCount,
                'percentage' => $attendancePercentage,
            ],
        ]);
    }
}
