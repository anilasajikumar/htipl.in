<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentPasswordSendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $course_students;
    public $password;
    public $enrollments;

    public function __construct($course_students, $password, $enrollments = [])
    {
        $this->course_students = $course_students;
        $this->password        = $password;
        $this->enrollments     = $enrollments;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('FROM_EMAIL'))->markdown('email.student_password');
    }
}
