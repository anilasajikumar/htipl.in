<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudyCenterPasswordSendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $center;
    public $password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($center, $password)
    {
        $this->center = $center; 
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('FROM_EMAIL'))->markdown('email.study_center_password');
    }
}
