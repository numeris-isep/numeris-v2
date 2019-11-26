<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BasicMail extends Mailable
{
    use Queueable, SerializesModels;

    private $notifiable;

    private $mailSubject;

    private $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($notifiable, string $subject, string $content)
    {
        $this->notifiable = $notifiable;
        $this->mailSubject = $subject;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->mailSubject)
            ->markdown('mails.basic', ['content' => $this->content]);
    }
}
