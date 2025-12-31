<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('class_schedules')) {
            Schema::create('class_schedules', function (Blueprint $table) {
                $table->id();
                $table->foreignId('technical_career_id')->constrained('technical_careers')->onDelete('cascade');
                $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
                $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
                $table->enum('day_of_week', ['lunes','martes','miércoles','jueves','viernes','sábado'])->nullable();
                $table->time('start_time')->nullable();
                $table->time('end_time')->nullable();
                $table->string('classroom')->nullable();
                $table->integer('block_number')->nullable();
                $table->integer('capacity')->default(40);
                $table->integer('semester')->nullable();
                $table->boolean('is_active')->default(true);
                $table->text('observations')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('class_schedules');
    }
};
