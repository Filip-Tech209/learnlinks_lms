<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseSchedule extends Model
{
    protected $fillable = [
        'course_id', 
        'delivery_mode',
        'start_date', 
        'end_date',
        'location', 
        'cost'
    ];
}

             