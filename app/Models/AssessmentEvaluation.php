<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentEvaluation extends Model
{
    protected $fillable = [
        'student_assessment_id', 'trainor_id',
        'comments', 'grade', 'score_override', 'evaluated_at',
    ];

    protected $casts = ['evaluated_at' => 'datetime'];

    public function studentAssessment()
    {
        return $this->belongsTo(StudentAssessment::class, 'student_assessment_id');
    }

    public function trainor()
    {
        return $this->belongsTo(Trainor::class, 'trainor_id');
    }
}
