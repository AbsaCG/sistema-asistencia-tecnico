<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Student;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceRegisterController extends Controller
{
    // Mostrar página landing
    public function index()
    {
        return Inertia::render('Landing');
    }

    // API: Registrar asistencia por DNI
    public function register(Request $request)
    {
        $data = $request->validate([
            'dni' => 'required|string|min:7',
        ]);

        // Limpiar DNI de espacios
        $dni = trim($data['dni']);

        // Buscar estudiante por DNI
        $student = Student::with('technicalCareer', 'user')
            ->where('dni', $dni)
            ->first();

        if (!$student) {
            return response()->json([
                'message' => 'Estudiante no encontrado con este DNI',
            ], 404);
        }

        // Verificar si ya tiene asistencia registrada hoy
        $today = Carbon::today();
        $existingAttendance = Attendance::where('student_id', $student->id)
            ->whereDate('date', $today)
            ->first();

        if ($existingAttendance) {
            return response()->json([
                'message' => 'La asistencia ya fue registrada hoy para este estudiante',
                'student' => [
                    'id' => $student->id,
                    'name' => $student->user->name ?? 'Desconocido',
                    'dni' => $student->dni,
                    'student_code' => $student->student_code,
                    'semester' => $student->semester,
                    'phone' => $student->phone,
                    'email' => $student->email,
                    'career_name' => $student->technicalCareer->name ?? null,
                ],
            ], 200);
        }

        // Crear registro de asistencia
        $attendance = Attendance::create([
            'student_id' => $student->id,
            'course_assignment_id' => null,
            'date' => $today,
            'time' => now()->format('H:i:s'),
            'status' => 'present',
            'registered_by' => null,
            'notes' => 'Registrado desde interfaz pública',
            'attendance_source' => 'public',
            'location' => 'Entrada Principal',
            'device_token' => null,
        ]);

        return response()->json([
            'message' => 'Asistencia registrada correctamente',
            'attendance_id' => $attendance->id,
            'student' => [
                'id' => $student->id,
                'name' => $student->user->name ?? 'Desconocido',
                'dni' => $student->dni,
                'student_code' => $student->student_code,
                'semester' => $student->semester,
                'phone' => $student->phone,
                'email' => $student->email,
                'career_name' => $student->technicalCareer->name ?? null,
            ],
        ], 200);
    }
}
