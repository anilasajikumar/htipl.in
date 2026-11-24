<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaLinks extends Model
{
    public function courseMedia()
{
    return $this->hasMany(\App\Models\CourseMedia::class, 'course_module_id');
}
}
