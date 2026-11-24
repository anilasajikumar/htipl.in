<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    use SoftDeletes;

   public function Exams()
   {
   		return $this->hasMany('App\Models\Exams','category_id');
   }

   public function OnlineCourse()
   {
   		return $this->hasMany('App\Models\OnlineCourse','category_id');
   }
}
