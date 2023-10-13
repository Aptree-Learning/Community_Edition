<div x-data="{ isOpen: false }"
     class="relative inline-block text-left"
    x-on:close-dropdown.window="isOpen = false"
    x-on:click.away="isOpen = false">
    <div x-on:click.prevent="isOpen = !isOpen">
        {{ $button }}
    </div>
    <div x-show="isOpen"
        x-cloak
        x-transition:enter="transition ease-out duration-100" 
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100" 
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100" 
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 z-10 min-w-[6rem] w-auto mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
        role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
        <div class="py-1 min-w-[16rem]" role="none">
            {{ $slot }}
        </div>
    </div>
</div>
