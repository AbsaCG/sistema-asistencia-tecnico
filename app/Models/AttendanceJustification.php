<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceJustification extends Model
{
    protected $fillable = ['attendance_id', 'reason', 'justification_document', 'approved_by', 'approved_at'];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
