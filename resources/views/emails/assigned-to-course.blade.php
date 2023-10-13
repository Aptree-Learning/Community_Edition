<x-mail::message>

@if ($logo)
<img src="{{ $logo }}" />
@endif

# You’ve been assigned!
Your course administrator has assigned you to a Course:

<x-mail::panel>
# {{$course->title }}
{{ $course->description }}
</x-mail::panel>

<x-mail::button :url="route('courses.show', $course->id)">
Go to my account
</x-mail::button>

Spend it on extra features or send it to your friends!
</x-mail::message>
