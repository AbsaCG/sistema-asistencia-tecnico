<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Student;
use App\Models\Attendance;

class StudentProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Obtener el estudiante asociado al usuario
        $student = Student::with(['program.faculty', 'user'])
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Calcular estadísticas del período actual
        $stats = [
            'attendance_percentage' => $this->calculateAttendancePercentage($student->id),
            'total_classes' => Attendance::where('student_id', $student->id)->count(),
            'absences' => Attendance::where('student_id', $student->id)
                ->where('status', 'absent')
                ->count(),
        ];

        // Formatear datos del estudiante
        $studentData = [
            'id' => $student->id,
            'full_name' => $student->user->name,
            'email' => $student->user->email,
            'initials' => $this->getInitials($student->user->name),
            'dni' => $student->dni,
            'code' => $student->code ?? 'N/A',
            'phone' => $student->phone ?? null,
            'address' => $student->address ?? null,
            'birth_date' => $student->birth_date ?? null,
            'program_name' => $student->program->name ?? 'N/A',
            'faculty_name' => $student->program->faculty->name ?? 'N/A',
            'status' => $student->status ?? 'active',
            'enrollment_date' => $student->created_at->format('d/m/Y'),
        ];

        return Inertia::render('Student/Profile', [
            'student' => $studentData,
            'stats' => $stats,
        ]);
    }

    private function getInitials($name)
    {
        $words = explode(' ', $name);
        if (count($words) >= 2) {
            return strtoupper($words[0][0] . $words[1][0]);
        }
        return strtoupper(substr($name, 0, 2));
    }

    private function calculateAttendancePercentage($studentId)
    {
        $total = Attendance::where('student_id', $studentId)->count();
        if ($total === 0) return 0;
        
        $present = Attendance::where('student_id', $studentId)
            ->where('status', 'present')
            ->count();
        
        return round(($present / $total) * 100, 1);
    }
}
