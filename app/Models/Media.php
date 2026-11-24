<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use SoftDeletes;

    const IMAGE = 'image';
    const VIDEO = 'video';
    const DOCUMENT = 'document';

     protected $fillable = [
        'course_media_id', 'title','file_name','thumbnail','file_path','mime_type',
        'extension','type','size','status'
    ];
}
