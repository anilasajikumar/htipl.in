<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\StudentCourse;

class StudentRegisteredMail extends Mailable
{
     use Queueable, SerializesModels;

    public $student;

    public function __construct(StudentCourse $student)
    {
        $this->student = $student;
    }

    public function build()
    {
        return $this->subject('Course Registration Successful')
                    ->view('email.student_registered');
    }
}
