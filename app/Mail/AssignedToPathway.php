<?php

namespace App\Mail;

use App\Models\Pathway;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AssignedToPathway extends Mailable
{
    use Queueable, SerializesModels;

    public $pathway;

    /**
     * Create a new message instance.
     */
    public function __construct(Pathway $pathway)
    {
        $this->pathway = $pathway;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Assigned To Pathway',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $logo = site_logo();

        return new Content(
            markdown: 'emails.assigned-to-pathway',
            with: [
                'pathway' => $this->pathway,
                'logo' => $logo
            ]
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
