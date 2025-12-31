<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\TechnicalCareer;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendanceExport;

class ReportController extends Controller
{
    public function attendance(Request $request)
    {
        // Obtener parámetros de filtro
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $careerId = $request->get('career_id');
        $status = $request->get('status');
        $studentId = $request->get('student_id');

        // Query base
        $query = Attendance::with(['student.user', 'student.technicalCareer']);

        // Aplicar filtros
        if ($startDate) {
            $query->whereDate('date', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->whereDate('date', '<=', $endDate);
        }

        if ($careerId) {
            $query->whereHas('student', function($q) use ($careerId) {
                $q->where('technical_career_id', $careerId);
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($studentId) {
            $query->where('student_id', $studentId);
        }

        // Obtener resultados
        $attendances = $query->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get()
            ->map(function($attendance) {
                $student = $attendance->student;
                
                return [
                    'id' => $attendance->id,
                    'student_id' => $student->id,
                    'student_name' => $student->user->name ?? 'Sin nombre',
                    'student_dni' => $student->dni ?? '—',
                    'student_code' => $student->code ?? '—',
                    'career' => $student->technicalCareer->name ?? 'Sin carrera',
                    'career_id' => $student->technical_career_id,
                    'status' => $attendance->status,
                    'time' => $attendance->time 
                        ? \Carbon\Carbon::parse($attendance->time)->format('H:i:s')
                        : '—',
                    'date' => $attendance->date 
                        ? \Carbon\Carbon::parse($attendance->date)->format('Y-m-d')
                        : '—',
                    'date_formatted' => $attendance->date 
                        ? \Carbon\Carbon::parse($attendance->date)->format('d/m/Y')
                        : '—',
                    'source' => $attendance->source ?? 'manual',
                ];
            });

        // Calcular estadísticas
        $stats = [
            'total' => $attendances->count(),
            'present' => $attendances->where('status', 'present')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'justified' => $attendances->where('status', 'justified')->count(),
        ];

        // Estadísticas por carrera
        $careerStats = $attendances->groupBy('career')->map(function($group, $career) {
            return [
                'career' => $career,
                'total' => $group->count(),
                'present' => $group->where('status', 'present')->count(),
                'late' => $group->where('status', 'late')->count(),
                'absent' => $group->where('status', 'absent')->count(),
            ];
        })->values();

        // Obtener listas para filtros
        $careers = TechnicalCareer::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'code']);

        $students = Student::with('user')
            ->get()
            ->map(function($student) {
                return [
                    'id' => $student->id,
                    'name' => $student->user->name ?? 'Sin nombre',
                    'dni' => $student->dni,
                    'code' => $student->code,
                ];
            });

        return Inertia::render('Reports/AttendanceReport', [
            'attendances' => $attendances,
            'stats' => $stats,
            'careerStats' => $careerStats,
            'careers' => $careers,
            'students' => $students,
            'filters' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'career_id' => $careerId,
                'status' => $status,
                'student_id' => $studentId,
            ]
        ]);
    }

    public function downloadPdf(Request $request)
    {
        $data = $this->getFilteredData($request);
        
        $pdf = Pdf::loadView('reports.attendance-pdf', $data);
        
        return $pdf->download('reporte-asistencia-' . date('Y-m-d') . '.pdf');
    }

    public function downloadExcel(Request $request)
    {
        return Excel::download(
            new AttendanceExport($this->getFilteredData($request)), 
            'reporte-asistencia-' . date('Y-m-d') . '.xlsx'
        );
    }

    private function getFilteredData(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $careerId = $request->get('career_id');
        $status = $request->get('status');
        $studentId = $request->get('student_id');

        $query = Attendance::with(['student.user', 'student.technicalCareer']);

        if ($startDate) {
            $query->whereDate('date', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->whereDate('date', '<=', $endDate);
        }

        if ($careerId) {
            $query->whereHas('student', function($q) use ($careerId) {
                $q->where('technical_career_id', $careerId);
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($studentId) {
            $query->where('student_id', $studentId);
        }

        $attendances = $query->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
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
                    'time' => $attendance->time 
                        ? \Carbon\Carbon::parse($attendance->time)->format('H:i:s')
                        : '—',
                    'date_formatted' => $attendance->date 
                        ? \Carbon\Carbon::parse($attendance->date)->format('d/m/Y')
                        : '—',
                    'source' => $attendance->source ?? 'manual',
                ];
            });

        $stats = [
            'total' => $attendances->count(),
            'present' => $attendances->where('status', 'present')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'justified' => $attendances->where('status', 'justified')->count(),
        ];

        return [
            'attendances' => $attendances,
            'stats' => $stats,
            'filters' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'career_id' => $careerId,
                'status' => $status,
                'student_id' => $studentId,
            ],
            'generated_at' => now()->format('d/m/Y H:i:s')
        ];
    }
}
