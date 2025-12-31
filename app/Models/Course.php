<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name', 
        'description', 
        'code', 
        'technical_career_id',
        'cycle',
        'credits',
        'hours'
    ];

    public function technicalCareer()
    {
        return $this->belongsTo(TechnicalCareer::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function courseAssignments()
    {
        return $this->hasMany(CourseAssignment::class);
    }
}
