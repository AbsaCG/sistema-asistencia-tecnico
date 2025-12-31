<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Student;
use App\Models\ClassSchedule;

class StudentScheduleViewController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Obtener el estudiante
        $student = Student::where('user_id', $user->id)->firstOrFail();

        // Obtener horario del estudiante basado en su programa/sección
        $schedules = ClassSchedule::with(['course.teacher'])
            ->where('program_id', $student->program_id)
            ->where('is_active', true)
            ->get();

        // Organizar horario por día
        $schedule = [
            'monday' => [],
            'tuesday' => [],
            'wednesday' => [],
            'thursday' => [],
            'friday' => [],
        ];

        $dayMapping = [
            'monday' => 'Lunes',
            'tuesday' => 'Martes',
            'wednesday' => 'Miércoles',
            'thursday' => 'Jueves',
            'friday' => 'Viernes',
        ];

        $colors = [
            'bg-blue-100 text-blue-800',
            'bg-green-100 text-green-800',
            'bg-purple-100 text-purple-800',
            'bg-pink-100 text-pink-800',
            'bg-yellow-100 text-yellow-800',
        ];

        $colorIndex = 0;

        foreach ($schedules as $item) {
            $day = strtolower($item->day_of_week);
            if (isset($schedule[$day])) {
                $schedule[$day][] = [
                    'time' => $item->start_time . ' - ' . $item->end_time,
                    'course' => $item->course->name ?? 'N/A',
                    'teacher' => $item->course->teacher->user->name ?? 'N/A',
                    'room' => $item->room ?? 'TBD',
                    'color' => $colors[$colorIndex % count($colors)],
                ];
                $colorIndex++;
            }
        }

        // Obtener próximas clases de hoy
        $today = now()->format('l'); // Monday, Tuesday, etc.
        $todaySchedules = ClassSchedule::with(['course.teacher'])
            ->where('program_id', $student->program_id)
            ->where('day_of_week', $today)
            ->where('is_active', true)
            ->whereTime('start_time', '>', now()->format('H:i:s'))
            ->orderBy('start_time')
            ->get();

        $upcomingClasses = $todaySchedules->map(function($item) {
            $start = \Carbon\Carbon::parse($item->start_time);
            $end = \Carbon\Carbon::parse($item->end_time);
            
            return [
                'id' => $item->id,
                'course' => $item->course->name ?? 'N/A',
                'teacher' => $item->course->teacher->user->name ?? 'N/A',
                'room' => $item->room ?? 'TBD',
                'time' => $start->format('H:i'),
                'duration' => $start->diffInMinutes($end),
            ];
        });

        return Inertia::render('Student/Schedule', [
            'schedule' => $schedule,
            'upcomingClasses' => $upcomingClasses,
        ]);
    }
}
