<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssessmentQuestion extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'assessment_id', 'question_text', 'question_type',
        'option_a', 'option_b', 'option_c', 'option_d',
        'correct_answer', 'marks', 'sort_order',
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class, 'assessment_id');
    }

    public function studentAnswers()
    {
        return $this->hasMany(StudentAssessmentAnswer::class, 'assessment_question_id');
    }
}
