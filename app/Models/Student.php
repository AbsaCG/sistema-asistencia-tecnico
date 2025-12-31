<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id', 'program_id', 'technical_career_id', 'dni', 'code', 'student_code', 'semester',
        'birth_date', 'address', 'phone', 'email',
        'parent_name', 'parent_phone', 'parent_email',
        'emergency_contact_name', 'emergency_contact_phone',
        'scholarship_status', 'observations',
        'photo', 'attachment_path', 'student_status', 'enrollment_date', 'active', 'is_active'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'enrollment_date' => 'datetime',
        'active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function technicalCareer()
    {
        return $this->belongsTo(TechnicalCareer::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
