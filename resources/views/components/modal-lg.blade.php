<x-base-modal ref="{{ $ref }}" backdrop="{{ isset($backdrop) ? $backdrop : false }}" class="lg:max-w-4xl">
    {{ $slot }}
</x-base-modal>