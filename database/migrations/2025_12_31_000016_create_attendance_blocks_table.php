<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('attendance_blocks')) {
            Schema::create('attendance_blocks', function (Blueprint $table) {
                $table->id();
                $table->foreignId('class_schedule_id')->constrained('class_schedules')->onDelete('cascade');
                $table->date('date')->nullable();
                $table->enum('block_status', ['scheduled','in_progress','completed','cancelled'])->default('scheduled');
                $table->timestamp('attendance_taken_at')->nullable();
                $table->foreignId('attendance_taken_by')->nullable()->constrained('users')->nullOnDelete();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_blocks');
    }
};
