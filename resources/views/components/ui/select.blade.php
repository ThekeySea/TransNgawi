@props([
    'label' => null,
    'id' => null,
    'error' => null,
    'options' => [],
])

@php
    $inputId = $id ?? $attributes->get('name');
@endphp

<div>
    @if ($label)
        <label for="{{ $inputId }}" class="input-label">{{ $label }}</label>
    @endif

    <select id="{{ $inputId }}" {{ $attributes->merge(['class' => 'select' . ($error ? ' border-error' : '')]) }}>
        {{ $slot }}
    </select>

    @if ($error)
        <p class="mt-1.5 text-sm text-error" role="alert">{{ $error }}</p>
    @endif
</div>
