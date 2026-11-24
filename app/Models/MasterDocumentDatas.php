<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterDocumentDatas extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title', 'text', 'file', 'download', 'student_upload',
        'course_id', 'category', 'default_file', 'student_download_default_file'
    ];
}
