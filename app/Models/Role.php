<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'slug', 'permissions'];

    protected $casts = [
        'permissions' => 'json',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Permission relation (normalized pivot).
     * Kept separate name to avoid collision with the existing `permissions` JSON attribute.
     */
    public function permissionModels()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }
}
