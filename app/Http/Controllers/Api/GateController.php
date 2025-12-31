<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;

class GateController extends Controller
{
    // POST /api/attendance/gate
    public function register(Request $request)
    {
        $data = $request->validate([
            'dni' => 'required|string',
            'device_token' => 'nullable|string',
            'location' => 'nullable|string',
            'status' => 'nullable|in:present,absent,late'
        ]);

        // Validate device token (basic): must exist in config.devices array or env
        $allowed = explode(',', env('GATE_DEVICE_TOKENS', ''));
        if ($data['device_token'] && ! in_array($data['device_token'], $allowed)) {
            return response()->json(['message' => 'Device token inválido'], 401);
        }

        $student = Student::where('dni', $data['dni'])->first();
        if (! $student) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        // Determine course_assignment / block mapping: naive fallback -> null
        $courseAssignmentId = null;

        $attendance = Attendance::create([
            'student_id' => $student->id,
            'course_assignment_id' => $courseAssignmentId,
            'date' => now()->toDateString(),
            'time' => now()->format('H:i:s'),
            'status' => $data['status'] ?? 'present',
            'registered_by' => null,
            'notes' => 'Registrado por puerta',
            'attendance_source' => 'gate',
            'location' => $data['location'] ?? null,
            'device_token' => $data['device_token'] ?? null,
        ]);

        return response()->json(['message' => 'Asistencia registrada', 'attendance_id' => $attendance->id]);
    }
}
