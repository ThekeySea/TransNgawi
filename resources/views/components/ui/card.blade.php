@props(['padding' => true])

<div {{ $attributes->merge(['class' => 'card']) }}>
    <div @class(['card-body' => $padding])>
        {{ $slot }}
    </div>
</div>
