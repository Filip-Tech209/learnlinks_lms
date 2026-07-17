<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_number',
        'first_name',
        'last_name',
        'email',
        'phone',
        'status',
        'admission_date',
    ];

    protected $casts = [
        'admission_date' => 'date',
    ];

    // Read-only accessor for clean UI output
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    // Relationships
    public function details()
    {
        return $this->hasOne(StudentDetail::class);
    }

    public function emergencyContacts()
    {
        return $this->hasMany(EmergencyContact::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // Shortcut to access all certificates through enrollments
    public function certificates()
    {
        return $this->hasManyThrough(Certificate::class, Enrollment::class);
    }
}