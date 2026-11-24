<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CenterRequestSendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $center;
    public $course_name;
    public $study_center_name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($center, $course_name, $study_center_name)
    {
        $this->center = $center; 
        $this->course_name = $course_name; 
        $this->study_center_name = $study_center_name; 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->from($this->center['email'])->markdown('email.study_center_request');
        return $this->from(env('FROM_EMAIL'))->markdown('email.study_center_request');

    }
}
