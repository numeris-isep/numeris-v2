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
        if (in_array($this->application->status, [Application::ACCEPTED, Application::REFUSED])) {
            $attribute = Preference::statusToAttribute()[$this->application->status];

            if ($this->application->user->preference->$attribute) {
                return ['mail'];
            }
        }

        return null;
    }

    public function toMail()
    {
        return (new ApplicationMail($this->application))
            ->to($this->application->user->email);
    }
}
