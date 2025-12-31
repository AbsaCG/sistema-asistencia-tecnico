<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GateController;
use App\Http\Controllers\AttendanceRegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public API endpoint for landing page attendance registration (no CSRF, no auth)
Route::post('/attendance/register', [AttendanceRegisterController::class, 'register']);

Route::post('/attendance/gate', [GateController::class, 'register']);

// Protected routes (require auth)
Route::middleware('auth:sanctum')->group(function () {
    // Get students by career and semester
    Route::get('/students', function (Request $request) {
        $students = \App\Models\Student::with(['user', 'technicalCareer'])
            ->when($request->career_id, function($query, $careerId) {
                $query->where('technical_career_id', $careerId);
            })
            ->when($request->semester, function($query, $semester) {
                $query->where('semester', $semester);
            })
            ->orderBy('id')
            ->get()
            ->map(function($student) {
                return [
                    'id' => $student->id,
                    'name' => $student->user->name ?? 'Sin nombre',
                    'dni' => $student->dni,
                    'code' => $student->code ?? $student->student_code ?? '—',
                    'semester' => $student->semester,
                    'career_name' => $student->technicalCareer->name ?? null,
                ];
            });

        return response()->json(['students' => $students]);
    });
});
