<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabla de Carreras Técnicas
        if (! Schema::hasTable('technical_careers')) {
            Schema::create('technical_careers', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->string('slug')->unique();
                $table->string('code')->unique();
                $table->text('description')->nullable();
                $table->integer('duration_semesters')->default(4);
                $table->integer('total_credits')->default(120);
                $table->string('coordinator_name')->nullable();
                $table->string('coordinator_email')->nullable();
                $table->text('requirements')->nullable();
                $table->decimal('tuition_amount', 10, 2)->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // Agregar columnas a students si no existen
        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasColumn('students', 'semester')) {
                $table->integer('semester')->default(1)->nullable();
            }
            if (!Schema::hasColumn('students', 'student_code')) {
                $table->string('student_code')->unique()->nullable();
            }
            if (!Schema::hasColumn('students', 'emergency_contact_name')) {
                $table->string('emergency_contact_name')->nullable();
            }
            if (!Schema::hasColumn('students', 'emergency_contact_phone')) {
                $table->string('emergency_contact_phone')->nullable();
            }
            if (!Schema::hasColumn('students', 'scholarship_status')) {
                $table->enum('scholarship_status', ['ninguno', 'parcial', 'completo'])->default('ninguno')->nullable();
            }
            if (!Schema::hasColumn('students', 'observations')) {
                $table->text('observations')->nullable();
            }
            if (!Schema::hasColumn('students', 'attachment_path')) {
                $table->string('attachment_path')->nullable();
            }
            if (!Schema::hasColumn('students', 'student_status')) {
                $table->enum('student_status', ['activo', 'inactivo', 'egresado', 'retirado'])->default('activo')->nullable();
            }
            if (!Schema::hasColumn('students', 'enrollment_date')) {
                $table->datetime('enrollment_date')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'semester', 'student_code',
                'emergency_contact_name', 'emergency_contact_phone',
                'scholarship_status', 'observations', 'attachment_path',
                'student_status', 'enrollment_date'
            ]);
        });
        Schema::dropIfExists('technical_careers');
    }
};
