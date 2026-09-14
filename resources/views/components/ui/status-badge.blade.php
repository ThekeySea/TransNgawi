@props(['status' => 'neutral'])

@php
    $variant = match (strtolower($status)) {
        'confirmed', 'paid', 'active', 'resolved', 'arrived', 'completed' => 'badge-success',
        'pending', 'waiting', 'waiting verification', 'boarding', 'scheduled', 'on_route', 'on route' => 'badge-warning',
        'rejected', 'cancelled', 'expired', 'closed', 'delayed' => 'badge-error',
        'departed', 'on route' => 'badge-info',
        default => 'badge-neutral',
    };
    $label = ucwords(str_replace('_', ' ', $status));
@endphp

<span {{ $attributes->merge(['class' => $variant]) }}>
    {{ $slot->isEmpty() ? $label : $slot }}
</span>
