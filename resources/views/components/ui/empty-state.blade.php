@props(['title' => 'Tidak ada data', 'description' => null, 'action' => null, 'actionLabel' => null])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center rounded-[var(--radius-lg)] border border-dashed border-border bg-surface px-6 py-16 text-center']) }}>
    <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-brand-muted text-brand">
        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
        </svg>
    </div>
    <h3 class="text-lg font-bold text-text">{{ $title }}</h3>
    @if ($description)
        <p class="mt-2 max-w-md text-sm text-text-muted">{{ $description }}</p>
    @endif
    @if ($action && $actionLabel)
        <x-ui.button href="{{ $action }}" class="mt-6">{{ $actionLabel }}</x-ui.button>
    @endif
    {{ $slot }}
</div>
