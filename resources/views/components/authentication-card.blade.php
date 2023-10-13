<div class="flex flex-col items-center min-h-screen pt-6 pb-8 bg-gray-100 sm:justify-center sm:pt-8">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full px-8 py-8 mt-6 overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-xl">
        {{ $slot }}
    </div>
</div>
