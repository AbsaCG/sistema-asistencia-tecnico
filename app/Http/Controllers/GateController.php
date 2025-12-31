<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;

class GateController extends Controller
{
    // Muestra la página rápida de ingreso por DNI
    public function index()
    {
        return inertia('Attendance/Gate');
    }

    // Verifica DNI y devuelve los datos del estudiante
    public function check(Request $request)
    {
        $data = $request->validate([
            'dni' => 'required|string',
        ]);

        $student = Student::with('technicalCareer')->where('dni', $data['dni'])->first();

        if (! $student) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        // If requested, register attendance immediately
        if ($request->boolean('register')) {
            Attendance::create([
                'student_id' => $student->id,
                'course_assignment_id' => null,
                'date' => now()->toDateString(),
                'time' => now()->format('H:i:s'),
                'status' => Attendance::STATUS_PRESENT,
                'registered_by' => auth()->id() ?? null,
                'notes' => 'Registrado desde interfaz de puerta',
                'attendance_source' => 'gate_manual',
                'location' => $request->input('location'),
                'device_token' => null,
            ]);
        }

        return response()->json([
            'id' => $student->id,
            'student_code' => $student->student_code,
            'name' => $student->user->name ?? null,
            'dni' => $student->dni,
            'semester' => $student->semester,
            'phone' => $student->phone,
            'email' => $student->email,
            'career' => $student->technicalCareer ? [ 'id' => $student->technicalCareer->id, 'name' => $student->technicalCareer->name, 'code' => $student->technicalCareer->code ] : null,
        ]);
    }
}
