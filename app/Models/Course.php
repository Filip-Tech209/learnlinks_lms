<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'category_id', 'title', 'description', 'base_price', 
        'delivery_method', 'duration', 'duration_classroom', 'is_active', 'featured_image', 'slug'
    ];

    public function category() { return $this->belongsTo(CourseCategory::class); }
    public function meta() { return $this->hasOne(CourseMeta::class); }
    public function modules() { return $this->hasMany(CourseModule::class)->orderBy('order'); }
    public function schedules() { return $this->hasMany(CourseSchedule::class); }
    public function faqs() { return $this->hasMany(CourseFaq::class); }
}