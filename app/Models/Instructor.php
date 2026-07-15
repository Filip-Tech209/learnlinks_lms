<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Instructor extends Model
{
    protected $fillable = [
        'instructor_number',
        'first_name',
        'last_name',
        'email',
        'phone',
        'status',
        'hire_date'
    ];

    public function detail(): HasOne
    {
        return $this->hasOne(InstructorDetail::class);
    }

    public function certifications(): HasMany
    {
        return $this->hasMany(InstructorCertification::class);
    }

    // Helper helper to get full name easily
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}