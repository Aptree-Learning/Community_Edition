<a href="{{ $link }}"
    class="{{ $active ? 'border-l-4 border-secondary bg-gray-100 text-black' : 'text-gray-500 hover:bg-gray-100 border-l-4 border-transparent' }} group flex items-center px-2 py-2 text-sm max-h-[40px] overflow-hidden "
    aria-current="page">
    {{ $icon }}
    <span class="hidden md:block" x-show="expand" x-transition x-cloak>{{ $label }}</span>
</a>