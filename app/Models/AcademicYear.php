<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    protected $fillable = ['name', 'start_date', 'end_date', 'active'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'active' => 'boolean',
    ];

    public function periods()
    {
        return $this->hasMany(AcademicPeriod::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
