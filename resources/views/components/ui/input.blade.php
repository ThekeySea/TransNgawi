@props([
    'label' => null,
    'id' => null,
    'error' => null,
    'hint' => null,
])

@php
    $inputId = $id ?? $attributes->get('name');
@endphp

<div {{ $attributes->only('class')->merge(['class' => '']) }}>
    @if ($label)
        <label for="{{ $inputId }}" class="input-label">{{ $label }}</label>
    @endif

    <input id="{{ $inputId }}" {{ $attributes->except('class')->merge(['class' => 'input' . ($error ? ' border-error focus:border-error focus:ring-error/20' : '')]) }} />

    @if ($error)
        <p class="mt-1.5 text-sm text-error" role="alert">{{ $error }}</p>
    @elseif ($hint)
        <p class="mt-1.5 text-sm text-text-subtle">{{ $hint }}</p>
    @endif
</div>
