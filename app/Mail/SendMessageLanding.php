<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMessageLanding extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $subjectLine;
    public $bodyMessage;

    public function __construct($email, $subjectLine, $bodyMessage)
    {
        $this->email = $email;
        $this->subjectLine = $subjectLine;
        $this->bodyMessage = $bodyMessage;
    }

    public function build()
    {
        return $this->from($this->email)
            ->subject($this->subjectLine)
            ->view('emails.contact');
    }
}
