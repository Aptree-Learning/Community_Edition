<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    
    <title>{{ config('app.name'). ' - Course Slider' }}</title>
    

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge"> <!-- † -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="url" content="{{ url('/') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">


    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @livewireStyles

    <style>
        html,body{
            font-family: 'Outfit', sans-serif;
        }
        [x-cloak]{
            display: none !important;
        }

        :root {
            --text-primary: {{ settings('text_primary') }};
            --text-secondary: {{ settings('text_secondary') }};
            --bg-primary: {{ settings('text_primary') }};
            --bg-secondary: {{ settings('text_secondary') }};
        }

    </style>

    @stack('head-scripts')
</head>
<body>

    {{ $slot }}

    @livewireScripts
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />
</body>
</html>
