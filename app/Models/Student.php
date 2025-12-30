<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id', 'code', 'dni', 'birth_date', 'address', 'phone',
        'parent_name', 'parent_phone', 'parent_email', 'photo', 'active'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
