<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['level_id', 'name', 'order'];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}
