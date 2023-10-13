<x-mail::message>
# Hello

{{ auth()->user()->name }} has registered in your site. The registered email is {{ auth()->user()->email }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
