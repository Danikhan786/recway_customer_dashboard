<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendCustomEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $body;
    public $attachment;

    /**
     * Create a new message instance.
     */
    public function __construct($subject, $body, $attachment = null)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->attachment = $attachment;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $email = $this->subject($this->subject)
            ->view('emails.custom') 
            ->with('body', $this->body);

        if ($this->attachment) {
            $email->attach($this->attachment);
        }

        return $email;
    }
}
