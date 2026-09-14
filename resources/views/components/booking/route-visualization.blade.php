@props(['origin', 'destination', 'service' => null])

<div {{ $attributes->merge(['class' => 'rounded-[var(--radius-md)] border border-border bg-surface p-6']) }}>
    <div class="flex items-center justify-between gap-4">
        <div class="text-center">
            <div class="mx-auto mb-2 flex h-10 w-10 items-center justify-center rounded-full bg-brand text-sm font-bold text-white">{{ strtoupper(substr($origin, 0, 2)) }}</div>
            <p class="text-sm font-semibold text-text">{{ $origin }}</p>
            <p class="text-xs text-text-muted">Asal</p>
        </div>

        <div class="flex flex-1 flex-col items-center">
            @if ($service)
                <span class="badge-info mb-2">{{ $service }}</span>
            @endif
            <div class="relative h-0.5 w-full bg-border">
                <div class="absolute left-0 top-1/2 h-2 w-2 -translate-y-1/2 rounded-full bg-brand"></div>
                <div class="absolute right-0 top-1/2 h-2 w-2 -translate-y-1/2 rounded-full bg-brand"></div>
            </div>
        </div>

        <div class="text-center">
            <div class="mx-auto mb-2 flex h-10 w-10 items-center justify-center rounded-full bg-brand text-sm font-bold text-white">{{ strtoupper(substr($destination, 0, 2)) }}</div>
            <p class="text-sm font-semibold text-text">{{ $destination }}</p>
            <p class="text-xs text-text-muted">Tujuan</p>
        </div>
    </div>
</div>
