@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-primary']) }}>
    {{ $value ?? $slot }}
</label>
