<?php

namespace App\Mail;

use App\Models\PlacementApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PlacementApplicationConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $application;

    public function __construct(PlacementApplication $application)
    {
        $this->application = $application;
    }

    public function build()
    {
        return $this->subject('Your Placement Application Received')
                    ->markdown('email.placement_application_confirmation');
    }
}
