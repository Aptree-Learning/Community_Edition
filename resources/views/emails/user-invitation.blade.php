<x-mail::message>

@if ($logo)
<img src="{{ $logo }}" />
@endif
Hello

Hi you have been invited you to join as a {{ $invitation->role }}, please click the link below to accept their invitation.


<x-mail::button :url="url('/invitation/'.$invitation->token)">
    Accept Invitation
</x-mail::button>

If the link isn't clickable in your email, you can manually copy paste this link to your browser tab:
{{ url('/invitation/'.$invitation->token) }}

Best,
The {{ config('app.name') }} Team
</x-mail::message>