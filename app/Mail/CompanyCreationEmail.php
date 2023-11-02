<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
class CompanyCreationEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $emailData;
    /**
     * Create a new message instance.
     */
    public function __construct($emailData)
    {
        $this->emailData = $emailData;
    }

    public function build()
    {
    return $this
        ->subject($this->emailData['subject'])
        ->to($this->emailData['email']) 
        ->view($this->emailData['view_name']); // Create a Blade view file for your email content
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailData['subject'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: $this->emailData['view_name'],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
