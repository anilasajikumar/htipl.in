<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Examupload extends Model
{
    protected $table = 'examupload';

    protected $fillable = [
        'title',
        'description',
        'file_path'
    ];
}
