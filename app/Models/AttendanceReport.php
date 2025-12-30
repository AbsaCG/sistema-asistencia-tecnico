<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceReport extends Model
{
    protected $fillable = ['type', 'filters', 'generated_by', 'file_path'];

    protected $casts = [
        'filters' => 'json',
    ];

    public function generatedBy()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
