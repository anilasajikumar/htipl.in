<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Auth;

class IncreaseLimitMail extends Mailable
{
    use Queueable, SerializesModels;

    public $course;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($course)
    {
        $this->course = $course;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->from(Auth::guard('center')->user()->study_center_email)->markdown('center.email.increase_limit_notification');
        return $this->from(env('FROM_EMAIL'))->markdown('center.email.increase_limit_notification');
    }
}
