<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = ['name', 'description', 'order'];

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
