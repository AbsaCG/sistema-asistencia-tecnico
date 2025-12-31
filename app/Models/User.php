<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Relations to eager load on every query
     */
    protected $with = ['role'];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'active' => 'boolean',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'registered_by');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function reports()
    {
        return $this->hasMany(AttendanceReport::class, 'generated_by');
    }

    /**
     * Check if the user has a permission.
     * Considers both the legacy JSON `permissions` on Role and the normalized pivot table.
     */
    public function hasPermission(string $permission): bool
    {
        $role = $this->role;

        if (!$role) {
            return false;
        }

        // Legacy JSON permissions
        $jsonPerms = $role->permissions;
        if (is_array($jsonPerms) && in_array($permission, $jsonPerms)) {
            return true;
        }

        // Normalized pivot permissions
        if ($role->permissionModels()->where('slug', $permission)->exists()) {
            return true;
        }

        return false;
    }

    /**
     * Check if the user has a specific role by name or slug
     */
    public function hasRole(string $roleName): bool
    {
        if (!$this->role) {
            return false;
        }
        
        $roleName = strtolower($roleName);
        return strtolower($this->role->name) === $roleName 
            || strtolower($this->role->slug) === $roleName;
    }

    /**
     * Check if the user has any of the given roles
     */
    public function hasAnyRole(array $roles): bool
    {
        if (!$this->role) {
            return false;
        }

        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if the user is a teacher
     */
    public function isTeacher(): bool
    {
        return $this->hasRole('teacher');
    }

    /**
     * Check if the user is a student
     */
    public function isStudent(): bool
    {
        return $this->hasRole('student');
    }

    /**
     * Check if the user is staff
     */
    public function isStaff(): bool
    {
        return $this->hasRole('staff');
    }
}
