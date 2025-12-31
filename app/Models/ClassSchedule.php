<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    protected $fillable = [
        'technical_career_id', 'course_id', 'teacher_id', 'day_of_week', 'start_time', 'end_time',
        'classroom', 'block_number', 'capacity', 'semester', 'is_active', 'observations'
    ];

    public function technicalCareer()
    {
        return $this->belongsTo(TechnicalCareer::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function attendanceBlocks()
    {
        return $this->hasMany(AttendanceBlock::class);
    }
}
