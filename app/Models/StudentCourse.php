<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;

class StudentCourse extends Authenticatable implements JWTSubject
{
	use Notifiable;
    use SoftDeletes;

   protected $casts = [
        'deleted_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'exam_date' => 'date',
        'dob' => 'date',
    ];

    protected $fillable = [
        'center_online_courses_id',
        'register_number',
        'exam_date',
        'name',
        'email',
        'mobile',
        'dob',
        'gender',
        'address',
        'password',
        'status',
        'result',
        'id_proof',
        'image',
        'father_name', 
        'passout_year_month', 
        'course_type',
        'remember_token'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    
    
    public function studentRegister(){
        return $this->hasOne(StudentRegisterNumber::class, 'student_courses_id');
    }
    
    
    
}
