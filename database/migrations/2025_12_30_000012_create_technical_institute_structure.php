<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Expandir tabla de estudiantes con campos técnicos
        Schema::table('students', function (Blueprint $table) {
            // Campos de identidad
            if (! Schema::hasColumn('students', 'dni')) {
                $table->string('dni')->unique()->after('id')->nullable();
            }
            try {
                // Change may fail if column not present or type not compatible
                if (Schema::hasColumn('students', 'birth_date')) {
                    $table->date('birth_date')->change(); // Asegurar que existe
                }
            } catch (\Exception $e) {
                // ignore change errors
            }

            // Información académica
            if (! Schema::hasColumn('students', 'semester')) {
                $table->integer('semester')->default(1)->after('program_id')->nullable(); // Semestre actual
            }
            if (! Schema::hasColumn('students', 'student_code')) {
                $table->string('student_code')->unique()->after('semester')->nullable(); // Código único del estudiante
            }

            // Información de contacto
            if (! Schema::hasColumn('students', 'phone')) {
                $table->string('phone')->after('address')->nullable();
            }
            if (! Schema::hasColumn('students', 'email')) {
                $table->string('email')->after('phone')->nullable();
            }

            // Información familiar/emergencia
            if (! Schema::hasColumn('students', 'emergency_contact_name')) {
                $table->string('emergency_contact_name')->after('parent_name')->nullable();
            }
            if (! Schema::hasColumn('students', 'emergency_contact_phone')) {
                $table->string('emergency_contact_phone')->after('emergency_contact_name')->nullable();
            }

            // Información socioeconómica
            if (! Schema::hasColumn('students', 'scholarship_status')) {
                $table->enum('scholarship_status', ['ninguno', 'parcial', 'completo'])->default('ninguno')->nullable();
            }
            if (! Schema::hasColumn('students', 'observations')) {
                $table->text('observations')->nullable();
            }

            // Documentos
            if (! Schema::hasColumn('students', 'photo')) {
                $table->string('photo')->nullable();
            }
            if (! Schema::hasColumn('students', 'attachment_path')) {
                $table->string('attachment_path')->nullable(); // Para documentos de admisión
            }

            // Estado
            if (! Schema::hasColumn('students', 'student_status')) {
                $table->enum('student_status', ['activo', 'inactivo', 'egresado', 'retirado'])->default('activo')->nullable();
            }
            if (! Schema::hasColumn('students', 'enrollment_date')) {
                $table->datetime('enrollment_date')->nullable();
            }
        });

        // Tabla de Carreras Técnicas
        Schema::create('technical_careers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // ej: "Producción Agropecuaria"
            $table->string('slug')->unique();
            $table->string('code')->unique(); // ej: "PA-2024"
            $table->text('description')->nullable();
            $table->integer('duration_semesters')->default(4); // Generalmente 4 semestres
            $table->integer('total_credits')->default(120);
            $table->string('coordinator_name')->nullable();
            $table->string('coordinator_email')->nullable();
            $table->text('requirements')->nullable(); // Requisitos de ingreso
            $table->decimal('tuition_amount', 10, 2)->nullable(); // Costo de matrícula
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'dni', 'semester', 'student_code', 'phone', 'email',
                'emergency_contact_name', 'emergency_contact_phone',
                'scholarship_status', 'observations', 'attachment_path',
                'student_status', 'enrollment_date'
            ]);
        });
        Schema::dropIfExists('technical_careers');
    }
};
