<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAssessmentAnswer extends Model
{
    protected $fillable = ['student_assessment_id', 'assessment_question_id', 'answer'];

    public function studentAssessment()
    {
        return $this->belongsTo(StudentAssessment::class, 'student_assessment_id');
    }

    public function question()
    {
        return $this->belongsTo(AssessmentQuestion::class, 'assessment_question_id');
    }
}
