<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assessment extends Model
{
    use SoftDeletes;

    protected $fillable = ['trainor_id', 'title', 'description', 'is_published'];

    public function trainor()
    {
        return $this->belongsTo(Trainor::class, 'trainor_id');
    }

    public function questions()
    {
        return $this->hasMany(AssessmentQuestion::class, 'assessment_id')->orderBy('sort_order');
    }

    public function studentAssessments()
    {
        return $this->hasMany(StudentAssessment::class, 'assessment_id');
    }

    public function getTotalMarksAttribute()
    {
        return $this->questions()->sum('marks');
    }
}
