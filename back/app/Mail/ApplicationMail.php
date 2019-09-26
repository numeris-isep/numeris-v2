<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Mail\Mailable;

class ApplicationMail extends Mailable
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
        return 'Candidature ' . trans('validation.attributes.' . $this->application->status);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->generateSubject())
            ->markdown('mails.application', ['application' => $this->application]);
    }
}
