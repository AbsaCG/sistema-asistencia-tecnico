<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Course;

class StudentAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Obtener el estudiante
        $student = Student::where('user_id', $user->id)->firstOrFail();

        // Obtener registros de asistencia
        $attendanceQuery = Attendance::with(['course', 'course.teacher'])
            ->where('student_id', $student->id)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc');

        // Aplicar filtros si existen
        if ($request->has('course_id') && $request->course_id) {
            $attendanceQuery->where('course_id', $request->course_id);
        }

        if ($request->has('start_date') && $request->start_date) {
            $attendanceQuery->where('date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $attendanceQuery->where('date', '<=', $request->end_date);
        }

        $attendanceRecords = $attendanceQuery->get()->map(function($record) {
            return [
                'id' => $record->id,
                'date' => $record->date,
                'time' => $record->created_at->format('H:i'),
                'course_name' => $record->course->name ?? 'N/A',
                'teacher_name' => $record->course->teacher->user->name ?? 'N/A',
                'status' => $record->status,
                'notes' => $record->notes,
            ];
        });

        // Calcular resumen
        $total = Attendance::where('student_id', $student->id)->count();
        $present = Attendance::where('student_id', $student->id)
            ->where('status', 'present')
            ->count();
        $absent = Attendance::where('student_id', $student->id)
            ->where('status', 'absent')
            ->count();
        
        $percentage = $total > 0 ? round(($present / $total) * 100, 1) : 0;

        $summary = [
            'total' => $total,
            'present' => $present,
            'absent' => $absent,
            'percentage' => $percentage,
        ];

        // Obtener cursos para filtro
        $courses = Course::whereHas('enrollments', function($query) use ($student) {
            $query->where('student_id', $student->id);
        })->get(['id', 'name']);

        return Inertia::render('Student/Attendance', [
            'summary' => $summary,
            'attendanceRecords' => $attendanceRecords,
            'courses' => $courses,
        ]);
    }
}
