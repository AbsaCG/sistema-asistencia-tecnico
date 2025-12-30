<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    const STATUS_PRESENT = 'present';
    const STATUS_ABSENT = 'absent';
    const STATUS_LATE = 'late';
    const STATUS_JUSTIFIED = 'justified';

    protected $fillable = ['student_id', 'course_assignment_id', 'date', 'time', 'status', 'registered_by', 'notes'];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function courseAssignment()
    {
        return $this->belongsTo(CourseAssignment::class);
    }

    public function registeredBy()
    {
        return $this->belongsTo(User::class, 'registered_by');
    }

    public function justification()
    {
        return $this->hasOne(AttendanceJustification::class);
    }
}
