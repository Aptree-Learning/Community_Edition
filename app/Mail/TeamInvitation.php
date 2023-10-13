<?php

namespace App\Mail;

use Arr;
use Str;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\URL;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use MailerSend\Helpers\Builder\Variable;
use Illuminate\Contracts\Queue\ShouldQueue;
use MailerSend\LaravelDriver\MailerSendTrait;
use Laravel\Jetstream\Mail\TeamInvitation as JetstreamTeamInvitation;
use Laravel\Jetstream\TeamInvitation as TeamInvitationModel;

class TeamInvitation extends Mailable
{
    use MailerSendTrait;
    use Queueable, SerializesModels;

    public $invitation;

    /**
     * Create a new message instance.
     *
     * @param  \Laravel\Jetstream\TeamInvitation  $invitation
     * @return void
     */
    public function __construct(TeamInvitationModel $invitation)
    {
        $this->invitation = $invitation;
    }
    
    public function build()
    {
        $invitation = $this->invitation;

        $to = Arr::get($this->to, '0.address');

        [$person_name, $domain] = explode('@', $invitation->email);

        return $this
            ->mailersend(
                template_id: 'vywj2lpox9j47oqz',
                variables: [
                    new Variable($to, [
                        'team.name' => $invitation->team->name,
                        'person.name' => $person_name,
                        'person.role' => Str::title($invitation->role),
                        'tenant.name' => settings('name'),
                        'account.name' => settings('name'),
                        'support_email' => config('mail.from.address'),
                        'invitation_link' => URL::signedRoute('team-invitations.accept', [ 'invitation' => $this->invitation])
                    ])
                ]
            );
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Invitation Email',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.invitation',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
    
}
