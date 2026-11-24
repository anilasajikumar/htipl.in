<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainCategories extends Model
{
    use SoftDeletes;

    protected $fillable = ['type', 'category_name', 'slug', 'description', 'cover_image', 'status'];

    public function Exams()
    {
        return $this->hasMany('App\Models\Exams', 'main_category_id');
    }

    public function OnlineCourse()
    {
        return $this->hasMany('App\Models\OnlineCourse', 'main_category_id');
    }
}
