<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use App\Models\Student;
use App\Models\AttendanceJustification;
use App\Models\Course;

class StudentJustificationViewController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Obtener el estudiante
        $student = Student::where('user_id', $user->id)->firstOrFail();

        // Obtener justificaciones
        $justifications = AttendanceJustification::with(['course', 'student', 'reviewedBy'])
            ->where('student_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'course_name' => $item->course->name ?? 'N/A',
                    'absence_date' => $item->absence_date,
                    'reason' => $item->reason,
                    'status' => $item->status,
                    'document_url' => $item->document_path ? Storage::url($item->document_path) : null,
                    'review_notes' => $item->review_notes,
                    'reviewed_by' => $item->reviewedBy->name ?? null,
                    'created_at' => $item->created_at->toISOString(),
                ];
            });

        // Calcular estadísticas
        $total = $justifications->count();
        $approved = $justifications->where('status', 'approved')->count();
        $pending = $justifications->where('status', 'pending')->count();
        $rejected = $justifications->where('status', 'rejected')->count();

        $stats = [
            'total' => $total,
            'approved' => $approved,
            'pending' => $pending,
            'rejected' => $rejected,
        ];

        // Obtener cursos del estudiante
        $courses = Course::whereHas('enrollments', function($query) use ($student) {
            $query->where('student_id', $student->id);
        })->get(['id', 'name']);

        return Inertia::render('Student/Justifications', [
            'justifications' => $justifications,
            'stats' => $stats,
            'courses' => $courses,
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'absence_date' => 'required|date',
            'reason' => 'required|string|max:1000',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
        ]);

        $documentPath = null;
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->store('justifications', 'public');
        }

        AttendanceJustification::create([
            'student_id' => $student->id,
            'course_id' => $validated['course_id'],
            'absence_date' => $validated['absence_date'],
            'reason' => $validated['reason'],
            'document_path' => $documentPath,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Justificación enviada correctamente');
    }
}
