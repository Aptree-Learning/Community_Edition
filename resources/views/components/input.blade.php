@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-darkgreen-500 focus:ring-darkgreen-500 rounded-md shadow-sm']) !!}>
