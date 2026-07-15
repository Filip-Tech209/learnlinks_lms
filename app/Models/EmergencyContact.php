<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    protected $fillable = [
        'student_id',
        'name',
        'relationship',
        'phone',
        'email',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}