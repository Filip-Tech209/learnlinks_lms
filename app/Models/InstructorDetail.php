<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstructorDetail extends Model
{
    protected $fillable = [
        'instructor_id',
        'date_of_birth',
        'gender',
        'address',
        'qualifications',
        'profile_image_path',
        'specialty'
    ];

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class);
    }
}