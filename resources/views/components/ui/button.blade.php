@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
])

@php
    $classes = match ($variant) {
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'destructive' => 'btn-destructive',
        default => 'btn-primary',
    };
    $sizeClass = match ($size) {
        'sm' => 'btn-sm',
        'lg' => 'btn-lg',
        default => 'btn-md',
    };
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "$classes $sizeClass"]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "$classes $sizeClass"]) }}>
        {{ $slot }}
    </button>
@endif
