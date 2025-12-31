<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Student;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['user', 'technicalCareer'])
            ->get()
            ->map(function($student) {
                $name = $student->user->name ?? 'Sin nombre';
                $parts = explode(' ', $name);
                $initials = count($parts) >= 2 
                    ? strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1))
                    : strtoupper(substr($name, 0, 2));
                    
                return [
                    'id' => $student->id,
                    'name' => $name,
                    'email' => $student->email ?? $student->user->email ?? '—',
                    'dni' => $student->dni,
                    'code' => $student->code,
                    'career' => $student->technicalCareer->name ?? null,
                    'status' => 'active', // TODO: agregar campo status a la tabla students
                    'initials' => $initials,
                ];
            });

        return Inertia::render('Students/Index', [
            'students' => $students
        ]);
    }

    public function create()
    {
        // Obtener lista de carreras para el select
        $careers = \App\Models\TechnicalCareer::select('id', 'name', 'code')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return Inertia::render('Students/Create', [
            'careers' => $careers
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'dni' => 'required|string|unique:students,dni|max:20',
            'code' => 'nullable|string|unique:students,code|max:50',
            'email' => 'required|email|unique:students,email',
            'technical_career_id' => 'required|exists:technical_careers,id',
            'semester' => 'required|integer|min:1|max:6',
            'phone' => 'nullable|string|max:20',
            'birthDate' => 'nullable|date',
        ]);

        // Crear usuario primero
        $user = \App\Models\User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['dni']), // Password inicial es el DNI
            'role_id' => 4, // Role student
            'active' => true,
        ]);

        // Crear estudiante
        $student = Student::create([
            'user_id' => $user->id,
            'dni' => $data['dni'],
            'code' => $data['code'] ?? null,
            'student_code' => $data['code'] ?? null,
            'email' => $data['email'],
            'technical_career_id' => $data['technical_career_id'],
            'semester' => $data['semester'],
            'phone' => $data['phone'] ?? null,
            'birth_date' => $data['birthDate'] ?? now()->subYears(18), // Por defecto 18 años atrás
            'is_active' => true,
        ]);

        return redirect()->route('students.index')->with('success', 'Estudiante creado correctamente');
    }

    public function show(Student $student)
    {
        $student->load(['user', 'technicalCareer']);
        
        $name = $student->user->name ?? 'Sin nombre';
        $parts = explode(' ', $name);
        $initials = count($parts) >= 2 
            ? strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1))
            : strtoupper(substr($name, 0, 2));
        
        $studentData = [
            'id' => $student->id,
            'name' => $name,
            'email' => $student->email ?? $student->user->email ?? '—',
            'dni' => $student->dni,
            'code' => $student->code,
            'career' => $student->technicalCareer->name ?? 'Sin carrera',
            'status' => 'active',
            'initials' => $initials,
            'phone' => $student->phone ?? '—',
            'address' => $student->address ?? '—',
        ];

        return Inertia::render('Students/Show', [
            'student' => $studentData
        ]);
    }

    public function edit(Student $student)
    {
        $student->load(['user', 'technicalCareer']);
        
        $name = $student->user->name ?? 'Sin nombre';
        
        $studentData = [
            'id' => $student->id,
            'name' => $name,
            'email' => $student->email ?? $student->user->email ?? '',
            'dni' => $student->dni,
            'code' => $student->code,
            'technical_career_id' => $student->technical_career_id,
            'phone' => $student->phone ?? '',
            'address' => $student->address ?? '',
        ];

        // Obtener lista de carreras para el select
        $careers = \App\Models\TechnicalCareer::select('id', 'name', 'code')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return Inertia::render('Students/Edit', [
            'student' => $studentData,
            'careers' => $careers
        ]);
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
            'dni' => 'sometimes|string|max:20',
            'code' => 'sometimes|string|max:20',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'technical_career_id' => 'nullable|exists:technical_careers,id',
        ]);

        // Actualizar usuario si se proporcionó nombre o email
        if (isset($validated['name']) || isset($validated['email'])) {
            $student->user->update([
                'name' => $validated['name'] ?? $student->user->name,
                'email' => $validated['email'] ?? $student->user->email,
            ]);
        }

        // Actualizar estudiante
        $student->update([
            'dni' => $validated['dni'] ?? $student->dni,
            'code' => $validated['code'] ?? $student->code,
            'phone' => $validated['phone'] ?? $student->phone,
            'address' => $validated['address'] ?? $student->address,
            'technical_career_id' => $validated['technical_career_id'] ?? $student->technical_career_id,
        ]);

        return redirect()->route('students.index')->with('success', 'Estudiante actualizado correctamente');
    }

    public function destroy(Student $student)
    {
        // Eliminar usuario asociado también
        $user = $student->user;
        $student->delete();
        if ($user) {
            $user->delete();
        }

        return redirect()->route('students.index')->with('success', 'Estudiante eliminado correctamente');
    }
}
