<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Teacher;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('user')
            ->get()
            ->map(function($teacher) {
                $name = $teacher->user->name ?? 'Sin nombre';
                $parts = explode(' ', $name);
                $initials = count($parts) >= 2 
                    ? strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1))
                    : strtoupper(substr($name, 0, 2));
                    
                return [
                    'id' => $teacher->id,
                    'name' => $name,
                    'email' => $teacher->user->email ?? '—',
                    'dni' => $teacher->dni ?? '—',
                    'code' => $teacher->code ?? '—',
                    'specialty' => $teacher->specialization ?? 'Sin especialidad',
                    'courses_count' => 0, // TODO: agregar relación con cursos
                    'status' => $teacher->active ? 'active' : 'inactive',
                    'initials' => $initials,
                ];
            });

        return Inertia::render('Teachers/Index', [
            'teachers' => $teachers
        ]);
    }

    public function create()
    {
        return Inertia::render('Teachers/Create');
    }

    public function store(Request $request)
    {
        // TODO: Implementar lógica de creación
        return redirect()->route('teachers.index');
    }

    public function show(Teacher $teacher)
    {
        $teacher->load('user');
        
        $name = $teacher->user->name ?? 'Sin nombre';
        $parts = explode(' ', $name);
        $initials = count($parts) >= 2 
            ? strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1))
            : strtoupper(substr($name, 0, 2));
        
        $teacherData = [
            'id' => $teacher->id,
            'name' => $name,
            'email' => $teacher->user->email ?? '—',
            'dni' => $teacher->dni ?? '—',
            'code' => $teacher->code ?? '—',
            'specialty' => $teacher->specialization ?? 'Sin especialidad',
            'phone' => $teacher->phone ?? '—',
            'address' => $teacher->address ?? '—',
            'status' => $teacher->active ? 'active' : 'inactive',
            'initials' => $initials,
        ];

        return Inertia::render('Teachers/Show', [
            'teacher' => $teacherData
        ]);
    }

    public function edit(Teacher $teacher)
    {
        $teacher->load('user');
        
        $name = $teacher->user->name ?? 'Sin nombre';
        
        $teacherData = [
            'id' => $teacher->id,
            'name' => $name,
            'email' => $teacher->user->email ?? '',
            'dni' => $teacher->dni ?? '',
            'code' => $teacher->code ?? '',
            'specialization' => $teacher->specialization ?? '',
            'phone' => $teacher->phone ?? '',
            'address' => $teacher->address ?? '',
            'active' => $teacher->active,
        ];

        return Inertia::render('Teachers/Edit', [
            'teacher' => $teacherData
        ]);
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
            'dni' => 'sometimes|string|max:20',
            'code' => 'sometimes|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'active' => 'sometimes|boolean',
        ]);

        // Actualizar usuario
        if (isset($validated['name']) || isset($validated['email'])) {
            $teacher->user->update([
                'name' => $validated['name'] ?? $teacher->user->name,
                'email' => $validated['email'] ?? $teacher->user->email,
            ]);
        }

        // Actualizar profesor
        $teacher->update([
            'dni' => $validated['dni'] ?? $teacher->dni,
            'code' => $validated['code'] ?? $teacher->code,
            'specialization' => $validated['specialization'] ?? $teacher->specialization,
            'phone' => $validated['phone'] ?? $teacher->phone,
            'address' => $validated['address'] ?? $teacher->address,
            'active' => $validated['active'] ?? $teacher->active,
        ]);

        return redirect()->route('teachers.index')->with('success', 'Profesor actualizado correctamente');
    }

    public function destroy(Teacher $teacher)
    {
        $user = $teacher->user;
        $teacher->delete();
        if ($user) {
            $user->delete();
        }

        return redirect()->route('teachers.index')->with('success', 'Profesor eliminado correctamente');
    }
}
