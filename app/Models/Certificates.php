<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificates extends Model
{
     protected $fillable = [
        'certificate_id',
        'exam_marks_id',
        'student_id',
        'student_name',
        'center_name',
        'course_name',
        'date_of_awarded',
        'total_mark_scored',
        'total_mark',
    ];
}
