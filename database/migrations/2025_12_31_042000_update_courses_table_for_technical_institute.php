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
        Schema::table('courses', function (Blueprint $table) {
            // Agregar solo el campo hours si no existe
            if (!Schema::hasColumn('courses', 'hours')) {
                $table->integer('hours')->default(0)->after('credits'); // Horas semanales
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (Schema::hasColumn('courses', 'hours')) {
                $table->dropColumn('hours');
            }
        });
    }
};
