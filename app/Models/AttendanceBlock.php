<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceBlock extends Model
{
    protected $fillable = [
        'class_schedule_id', 'date', 'block_status', 'attendance_taken_at', 'attendance_taken_by', 'notes'
    ];

    public function classSchedule()
    {
        return $this->belongsTo(ClassSchedule::class);
    }

    public function attendances()
    {
        return $this->hasMany(\App\Models\Attendance::class);
    }
}
