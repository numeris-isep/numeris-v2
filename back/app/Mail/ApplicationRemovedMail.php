<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Mail\Mailable;

class ApplicationRemovedMail extends Mailable
{
    protected $application;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    private function generateSubject(): string
    {
        return sprintf(
            '[Candidature retirée] %s - %s',
            $this->application->user->getFullName(),
            $this->application->mission->title
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->generateSubject())
            ->markdown('mails.application-removed', ['application' => $this->application]);
    }
}
