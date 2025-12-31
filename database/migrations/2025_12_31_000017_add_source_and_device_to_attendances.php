<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            if (! Schema::hasColumn('attendances', 'attendance_source')) {
                $table->enum('attendance_source', ['in_class','gate','remote','public'])->default('in_class')->after('status');
            } else {
                // Actualizar enum si ya existe
                try {
                    $table->enum('attendance_source', ['in_class','gate','remote','public'])->default('in_class')->change();
                } catch (\Exception $e) {
                    // Ignorar si no se puede actualizar
                }
            }
            if (! Schema::hasColumn('attendances', 'location')) {
                $table->string('location')->nullable()->after('attendance_source');
            }
            if (! Schema::hasColumn('attendances', 'device_token')) {
                $table->string('device_token')->nullable()->after('location');
            }
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            foreach (['attendance_source','location','device_token'] as $col) {
                if (Schema::hasColumn('attendances', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
