<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamCenters extends Model
{
	use SoftDeletes;

   public function studentExams()
   {
   		return $this->hasMany('App\Models\StudentExams','exam_center_id');
   }
}
