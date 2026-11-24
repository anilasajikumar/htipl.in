<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Auth;

class CreateExamNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $exam;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($exam)
    {
        $this->exam = $exam;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->from(Auth::guard('center')->user()->study_center_email)->markdown('center.email.exam_notification');
        return $this->from(env('FROM_EMAIL'))->markdown('center.email.exam_notification');

    }
}
