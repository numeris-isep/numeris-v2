<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    private $notifiable;

    private $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($notifiable, $url)
    {
        $this->notifiable = $notifiable;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Vérification de l\'adresse email de votre compte Numéris')
            ->markdown('mails.verify-email', ['notifiable' => $this->notifiable, 'url' => $this->url]);
    }
}
