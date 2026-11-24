<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class VideoTestimonial extends Model
{
    
    use SoftDeletes;
    
    protected $table = 'video_testimonials';
    

    protected $fillable = [
        'title',
        'description',
        'video_link',
        'status'
    ];


}
