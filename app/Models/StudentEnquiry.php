<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class StudentEnquiry extends Model
{
    
    use SoftDeletes;
    protected $table = 'student_enquiries';
    
  protected $fillable = [
        'name',
        'email',
        'contact_number',
        'center_id',
        'course_id',
        'message',
        'dob'
    ];

    public function center()
    {
        return $this->belongsTo(Centers::class, 'center_id');
    }

    public function course()
    {
        return $this->belongsTo(OnlineCourse::class, 'course_id');
    }
}
