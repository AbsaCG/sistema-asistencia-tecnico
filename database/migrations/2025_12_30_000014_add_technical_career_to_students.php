<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Agregar columna de carrera técnica si no existe
            if (!Schema::hasColumn('students', 'technical_career_id')) {
                $table->unsignedBigInteger('technical_career_id')->nullable()->after('program_id');
                $table->foreign('technical_career_id')->references('id')->on('technical_careers')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (Schema::hasColumn('students', 'technical_career_id')) {
                $table->dropForeign(['technical_career_id']);
                $table->dropColumn('technical_career_id');
            }
        });
    }
};
