<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    class ExamSubmission extends Model
{
    protected $table = 'exam_submissions';

    protected $fillable = [
        'exam_id',
        'student_id',
        'file_path',
        'submitted_at'
    ];
}

}
