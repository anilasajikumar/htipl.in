<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentExams extends Model
{
	use SoftDeletes;

    public function ExamCenters()
    {
        return $this->belongsTo('App\Model\ExamCenters');
    }
}
