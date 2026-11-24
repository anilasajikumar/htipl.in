<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EnquiryForm extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'email', 'contact_number', 'dob', 'gender', 'address',
        'center', 'course', 'message', 'enquiry_date'
    ];
}
