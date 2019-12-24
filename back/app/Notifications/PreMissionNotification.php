<?php

namespace App\Notifications;

use App\Mail\BasicMail;
use App\Models\Application;
use App\Models\Mission;

class PreMissionNotification extends AbstractNotification
{
    private $mission;

    private $subject;

    private $content;

    public function __construct(Mission $mission, string $subject, string $content)
    {
        $this->mission = $mission;
        $this->subject = $subject;
        $this->content = $content;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new BasicMail($this->subject, $this->content))
            ->to($this->getEmails());
    }

    private function getEmails(): array
    {
        return $this->mission
            ->applications
            ->filter(function (Application $a) {
                return $a->status === Application::ACCEPTED;
            })
            ->map(function (Application $a) {
                return $a->user;
            })
            ->pluck('email')
            ->all();
    }
}
