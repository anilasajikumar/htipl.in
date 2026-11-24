<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CenterOnlineCourse extends Model
{
	use SoftDeletes;

   public function studentCourse()
   {
   		return $this->hasMany('App\Models\StudentCourse','center_online_courses_id');
   }
}
