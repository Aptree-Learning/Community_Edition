<x-mail::message>
# Hello

You have been invited to join our platform. Please click the button below to complete your registration.


<x-mail::button :url="url('/invitation/'.$invitation->token.'?email=' . $invitation->email )">
    Accept Invitation
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
