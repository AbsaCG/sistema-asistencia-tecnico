<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['course_assignment_id', 'day_of_week', 'start_time', 'end_time', 'classroom'];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    public function courseAssignment()
    {
        return $this->belongsTo(CourseAssignment::class);
    }
}
