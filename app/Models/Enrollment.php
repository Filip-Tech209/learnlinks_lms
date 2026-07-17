<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'student_id',
        'course_id',
        'enrollment_date',
        'status',
        'progress_percent'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function progressLogs()
    {
        return $this->hasMany(CourseProgress::class);
    }

    public function certificate()
    {
        return $this->hasOne(Certificate::class);
    }
}