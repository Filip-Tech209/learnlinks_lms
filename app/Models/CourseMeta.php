<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseMeta extends Model
{
    protected $table = 'course_meta';
    protected $fillable = [
        'course_id', 'objectives', 'organizational_impacts', 
        'personal_impacts', 'brochure_path', 'certification_details', 
        'language', 'requirements','training_methodology'
    ];
}