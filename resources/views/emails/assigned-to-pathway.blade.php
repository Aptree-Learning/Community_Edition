<x-mail::message>

@if ($logo)
<img src="{{ $logo }}" />
@endif

# You’ve been assigned!
Your course administrator has assigned you to a Pathway:

<x-mail::panel>
# {{$pathway->title }}
{{ $pathway->description }}
</x-mail::panel>

<x-mail::button :url="route('pathway.show', $pathway->id)">
Go to my account
</x-mail::button>

Spend it on extra features or send it to your friends!
</x-mail::message>
