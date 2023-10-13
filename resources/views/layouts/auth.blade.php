<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            html,body{
                font-family: 'Outfit', sans-serif;
            }
            :root {
                --text-primary: {{ settings('text_primary') }};
                --text-secondary: {{ settings('text_secondary') }};
                --bg-primary: {{ settings('text_primary') }};
                --bg-secondary: {{ settings('text_secondary') }};
            }
    
        </style>

        @livewireStyles
    </head>
    <body>
        <div class="antialiased text-gray-600">
            {{ $slot }}
        </div>


        <div class="flex justify-center pb-6 bg-gray-100">
            <p class="text-sm text-primary">View our <a href="{{ url('terms-of-service') }}" target="_blank" class="font-bold">terms and conditions</a> & <a href="{{ url('privacy-policy') }}" target="_blank" class="font-bold">privacy policy</a></p>
        </div>
        
        @livewireScripts

        @stack('scripts')
    </body>
</html>
