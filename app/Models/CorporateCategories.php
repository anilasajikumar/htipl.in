<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CorporateCategories extends Model
{
    use SoftDeletes;

    public function corporateCourse()
   {
        return $this->hasMany('App\Models\CorporateCourses','category_id');
   }
}
