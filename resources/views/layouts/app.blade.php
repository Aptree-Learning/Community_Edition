<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>{{ settings('name') }} | @yield('title', 'Home')</title>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge"> <!-- † -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="url" content="{{ url('/') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.0/flowbite.min.js"></script>
    <script src="https://unpkg.com/@api.video/media-stream-composer"></script>
    <!-- Styles -->
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
            --bg-primary-10: {{ settings('text_primary').'1a' }};
            --bg-secondary: {{ settings('text_secondary') }};
            --bg-secondary-10: {{ settings('text_secondary').'1a' }};
        }

    </style>

    @stack('head-scripts')
</head>
<body class="bg-gray-100">
    <x-banner />
    <div class="flex">

        @include('includes.partials.sidebar')

        <div class="flex-1">
            <div class="!max-h-screen overflow-auto">
                @include('includes.partials.header')
                <div class="bg-white md:px-8">
                    @yield('header')
                    {{ $header ?? '' }}
                </div>
    
                <main class="flex-grow">
                    <div class="min-h-[calc(100vh-142px)]">
                        @yield('content')
                        {{ $slot ?? '' }}
                    </div>
    
                    @include('includes.partials.footer')
                </main>
            </div>
        </div>

    </div>

    @yield('javascript')

    @livewireScripts
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />


</body>
</html>
