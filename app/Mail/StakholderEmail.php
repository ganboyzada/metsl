<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StakholderEmail extends Mailable
{
    use Queueable, SerializesModels;
    private $name;
    private $job_title;
    private $pass;

    private $email;

    /**
     * Create a new message instance.
     */
    public function __construct(string $name , string $job_title ,string $email , string $pass)
    {
        $this->name = $name;
        $this->job_title = $job_title;
        $this->pass = $pass;
        $this->email = $email;

    
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invitaion From Metsl',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.team-invitation2',
            with: ['name' => $this->name , 'job_title' => $this->job_title , 'email' => $this->email , 'pass' => $this->pass],
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
