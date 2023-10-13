@props(['ref'])

<x-base-modal ref="{{ $ref }}" backdrop="{{ isset($backdrop) ? $backdrop : false }}" class="lg:max-w-2xl">
    {{ $slot }}
</x-base-modal>