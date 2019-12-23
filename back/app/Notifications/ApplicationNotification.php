<?php

namespace App\Notifications;

use App\Mail\ApplicationMail;
use App\Models\Application;
use App\Models\Preference;

class ApplicationNotification extends AbstractNotification
{
    private $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new ApplicationMail($this->application))
            ->to($notifiable->email);
    }
}
