<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TechnicalCareer extends Model
{
    protected $table = 'technical_careers';

    protected $fillable = [
        'name',
        'slug',
        'code',
        'description',
        'duration_semesters',
        'total_credits',
        'coordinator_name',
        'coordinator_email',
        'requirements',
        'tuition_amount',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'tuition_amount' => 'decimal:2',
    ];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'technical_career_id');
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'technical_career_id');
    }
}
