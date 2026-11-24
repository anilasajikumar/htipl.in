<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAssessment extends Model
{
    protected $fillable = [
        'student_course_id', 'assessment_id', 'status',
        'started_at', 'submitted_at', 'score', 'total_marks',
    ];

    protected $casts = [
        'started_at'   => 'datetime',
        'submitted_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(StudentCourse::class, 'student_course_id');
    }

    public function assessment()
    {
        return $this->belongsTo(Assessment::class, 'assessment_id');
    }

    public function answers()
    {
        return $this->hasMany(StudentAssessmentAnswer::class, 'student_assessment_id');
    }

    public function evaluation()
    {
        return $this->hasOne(AssessmentEvaluation::class, 'student_assessment_id');
    }
}
