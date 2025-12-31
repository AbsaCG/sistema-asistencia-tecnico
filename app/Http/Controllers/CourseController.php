<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['technicalCareer'])
            ->get()
            ->map(function($course) {
                // Determinar el ciclo romano
                $cycleRoman = match($course->cycle) {
                    1 => 'I',
                    2 => 'II',
                    3 => 'III',
                    4 => 'IV',
                    5 => 'V',
                    6 => 'VI',
                    default => '—'
                };
                
                return [
                    'id' => $course->id,
                    'code' => $course->code,
                    'name' => $course->name,
                    'career' => $course->technicalCareer->name ?? 'Transversal',
                    'cycle' => $cycleRoman,
                    'credits' => $course->credits ?? 0,
                    'hours' => $course->hours ?? 0,
                    'teacher' => null, // TODO: agregar relación con teacher
                    'status' => 'active',
                ];
            });

        return Inertia::render('Courses/Index', [
            'courses' => $courses
        ]);
    }

    public function create()
    {
        return Inertia::render('Courses/Create');
    }

    public function store(Request $request)
    {
        // TODO: Implementar lógica de creación
        return redirect()->route('courses.index');
    }

    public function show(Course $course)
    {
        $course->load('technicalCareer');
        
        $cycleRoman = match($course->cycle) {
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            default => '—'
        };
        
        $courseData = [
            'id' => $course->id,
            'code' => $course->code,
            'name' => $course->name,
            'description' => $course->description ?? 'Sin descripción',
            'career' => $course->technicalCareer->name ?? 'Transversal',
            'cycle' => $cycleRoman,
            'cycle_number' => $course->cycle,
            'credits' => $course->credits ?? 0,
            'hours' => $course->hours ?? 0,
            'status' => 'active',
        ];

        return Inertia::render('Courses/Show', [
            'course' => $courseData
        ]);
    }

    public function edit(Course $course)
    {
        $course->load('technicalCareer');
        
        $courseData = [
            'id' => $course->id,
            'code' => $course->code,
            'name' => $course->name,
            'description' => $course->description ?? '',
            'technical_career_id' => $course->technical_career_id,
            'cycle' => $course->cycle,
            'credits' => $course->credits ?? 0,
            'hours' => $course->hours ?? 0,
        ];

        // Obtener lista de carreras para el select
        $careers = \App\Models\TechnicalCareer::select('id', 'name', 'code')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return Inertia::render('Courses/Edit', [
            'course' => $courseData,
            'careers' => $careers
        ]);
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'code' => 'sometimes|string|max:20',
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'technical_career_id' => 'nullable|exists:technical_careers,id',
            'cycle' => 'sometimes|integer|min:1|max:6',
            'credits' => 'sometimes|integer|min:0',
            'hours' => 'sometimes|integer|min:0',
        ]);

        $course->update($validated);

        return redirect()->route('courses.index')->with('success', 'Unidad didáctica actualizada correctamente');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Unidad didáctica eliminada correctamente');
    }
}
