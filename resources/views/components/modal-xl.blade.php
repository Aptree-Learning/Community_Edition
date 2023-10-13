<x-base-modal ref="{{ $ref }}" backdrop="{{ isset($backdrop) ? $backdrop : false }}" class="lg:max-w-6xl">
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    {{ $slot }}
</x-base-modal>