<?php

namespace App\Http\Controllers;

use App\Models\ClassSchedule;
use App\Models\TechnicalCareer;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = ClassSchedule::with(['technicalCareer','course','teacher'])->paginate(15);
        return inertia('Academic/Schedules/Index', compact('schedules'));
    }

    public function create()
    {
        $careers = TechnicalCareer::where('is_active', true)->get();
        return inertia('Academic/Schedules/Create', compact('careers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'technical_career_id' => 'required|exists:technical_careers,id',
            'course_id' => 'required|exists:courses,id',
            'teacher_id' => 'required|exists:teachers,id',
            'day_of_week' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
            'classroom' => 'nullable|string',
            'block_number' => 'nullable|integer',
            'semester' => 'nullable|integer',
        ]);

        ClassSchedule::create($data);
        return redirect()->route('schedules.index')->with('success', 'Horario creado');
    }
}
