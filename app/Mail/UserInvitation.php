<?php

namespace App\Mail;

use App\Models\UserInvitation as UserInvitationModel;
use App\Models\Settings;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class UserInvitation extends Mailable
{
    use Queueable, SerializesModels;
    public $invitation;
    /**
     * Create a new message instance.
     */
    public function __construct(protected UserInvitationModel $invitation1)
    {
        $this->invitation = $invitation1;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'User Invitation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $logo = Settings::whereKey('logo')->first()->value ?? "";
        return new Content(
            markdown: 'emails.user-invitation',
            with: [
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
