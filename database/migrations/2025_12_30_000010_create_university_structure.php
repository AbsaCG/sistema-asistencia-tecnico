<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Facultades/Facultys
        Schema::create('faculties', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('dean_name')->nullable();
            $table->string('dean_email')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Carreras/Programs
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faculty_id')->constrained('faculties')->onDelete('cascade');
            $table->string('name'); // ej: "Ingeniería en Sistemas"
            $table->string('slug');
            $table->string('code')->unique(); // ej: "IS-2024"
            $table->integer('duration_semesters')->default(8);
            $table->integer('total_credits')->default(240);
            $table->text('description')->nullable();
            $table->string('coordinator_email')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['faculty_id', 'slug']);
        });

        // Cursos/Materias (Courses ya existe, lo adaptamos)
        Schema::table('courses', function (Blueprint $table) {
            if (! Schema::hasColumn('courses', 'program_id')) {
                $table->foreignId('program_id')->nullable()->constrained('programs')->onDelete('set null');
            }
            if (! Schema::hasColumn('courses', 'credits')) {
                $table->integer('credits')->default(3);
            }
            if (! Schema::hasColumn('courses', 'semester')) {
                $table->integer('semester')->nullable(); // Semestre en que se dicta
            }
            if (! Schema::hasColumn('courses', 'code')) {
                $table->string('code')->nullable()->unique(); // ej: "SIS-101"
            }
            if (! Schema::hasColumn('courses', 'is_required')) {
                $table->boolean('is_required')->default(true);
            }
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (Schema::hasColumn('courses', 'program_id')) {
                try {
                    $table->dropConstrainedForeignId('program_id');
                } catch (\Exception $e) {
                    // ignore if constraint not present
                }
            }
            $cols = [];
            foreach (['credits', 'semester', 'code', 'is_required'] as $c) {
                if (Schema::hasColumn('courses', $c)) {
                    $cols[] = $c;
                }
            }
            if (count($cols)) {
                $table->dropColumn($cols);
            }
        });
        Schema::dropIfExists('programs');
        Schema::dropIfExists('faculties');
    }
};
