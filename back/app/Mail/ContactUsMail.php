<?php

namespace App\Mail;

use App\Http\Requests\ContactUsRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    private $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->getSubject())
            ->replyTo($this->data['email'])
            ->markdown('mails.contact-us', [
                'user'      => $this->getFullName(),
                'email'     => $this->data['email'],
                'subject'   => $this->data['subject'],
                'content'   => $this->data['content'],
            ]);
    }

    private function getSubject()
    {
        return sprintf(
            '[Formulaire de contact] %s - %s %s',
            $this->data['subject'],
            $this->data['first_name'],
            mb_strtoupper($this->data['last_name'], 'UTF-8')
        );
    }

    private function getFullName()
    {
        return sprintf(
            '%s %s',
            $this->data['first_name'],
            mb_strtoupper($this->data['last_name'], 'UTF-8')
        );
    }
}
