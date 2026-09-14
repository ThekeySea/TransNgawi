@props(['lines' => 3])

<div {{ $attributes->merge(['class' => 'animate-pulse space-y-4']) }} role="status" aria-label="Memuat...">
    @for ($i = 0; $i < $lines; $i++)
        <div @class(['h-4 rounded bg-border', 'w-full' => $i % 2 === 0, 'w-3/4' => $i % 2 !== 0])></div>
    @endfor
    <span class="sr-only">Memuat...</span>
</div>
