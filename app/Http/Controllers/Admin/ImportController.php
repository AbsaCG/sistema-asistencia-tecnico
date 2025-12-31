<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Student;
use App\Models\Role;
use App\Models\TechnicalCareer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function index()
    {
        $careers = TechnicalCareer::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'code']);

        $studentRole = Role::where('name', 'student')->first();

        return Inertia::render('Admin/Import', [
            'careers' => $careers,
            'studentRoleExists' => $studentRole ? true : false,
        ]);
    }

    public function importStudents(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
            'career_id' => 'required|exists:technical_careers,id',
        ]);

        try {
            DB::beginTransaction();

            $file = $request->file('file');
            $data = Excel::toArray([], $file)[0]; // Primera hoja

            // Obtener rol de estudiante
            $studentRole = Role::where('name', 'student')->first();
            if (!$studentRole) {
                throw new \Exception('El rol "student" no existe. Créelo primero.');
            }

            $imported = 0;
            $errors = [];
            $skipped = 0;

            // Saltar la primera fila (encabezados)
            foreach (array_slice($data, 1) as $index => $row) {
                $rowNumber = $index + 2; // +2 porque empezamos en 1 y saltamos header

                // Validar que tenga al menos 3 columnas: DNI, Nombre, Email
                if (count($row) < 3) {
                    $errors[] = "Fila $rowNumber: Datos incompletos";
                    continue;
                }

                $dni = trim($row[0] ?? '');
                $name = trim($row[1] ?? '');
                $email = trim($row[2] ?? '');
                $code = trim($row[3] ?? ''); // Código de estudiante (opcional)

                // Validaciones básicas
                if (empty($dni) || empty($name)) {
                    $errors[] = "Fila $rowNumber: DNI o nombre vacío";
                    continue;
                }

                // Verificar si ya existe
                if (User::where('email', $email)->exists()) {
                    $skipped++;
                    continue;
                }

                if (Student::where('dni', $dni)->exists()) {
                    $skipped++;
                    continue;
                }

                // Crear usuario
                $user = User::create([
                    'name' => $name,
                    'email' => $email ?: $dni . '@istp.edu.pe', // Email por defecto si no tiene
                    'password' => Hash::make($dni), // Contraseña = DNI por defecto
                    'role_id' => $studentRole->id,
                    'active' => true,
                ]);

                // Crear estudiante
                Student::create([
                    'user_id' => $user->id,
                    'dni' => $dni,
                    'code' => $code ?: 'EST-' . str_pad($dni, 8, '0', STR_PAD_LEFT),
                    'email' => $email ?: $dni . '@istp.edu.pe',
                    'technical_career_id' => $request->career_id,
                ]);

                $imported++;
            }

            DB::commit();

            return redirect()->back()->with('success', 
                "✅ Importación exitosa: $imported estudiantes importados, $skipped omitidos (ya existían)" .
                (count($errors) > 0 ? "\n⚠️ " . count($errors) . " errores encontrados" : "")
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al importar: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="plantilla-estudiantes.csv"',
        ];

        $csvData = "DNI,Nombre Completo,Email,Código Estudiante\n";
        $csvData .= "12345678,Juan Pérez García,juan.perez@email.com,EST00001\n";
        $csvData .= "87654321,María López Torres,maria.lopez@email.com,EST00002\n";
        $csvData .= "45678912,Carlos Ramírez Díaz,carlos.ramirez@email.com,EST00003\n";

        return response()->make($csvData, 200, $headers);
    }
}
