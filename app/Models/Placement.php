<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Placement extends Model
{
    protected $fillable = [
        'post_name',
        'experience',
        'company',
        'salary',
        'qualification',
        'last_date_to_apply',
    ];
}
