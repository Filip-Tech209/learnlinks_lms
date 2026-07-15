<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentDetail extends Model
{
    protected $fillable = [
        'student_id',
        'date_of_birth',
        'gender',
        'address',
        'national_id_or_passport',
        'profile_image_path',
        'academic_background',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}