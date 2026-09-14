@props(['title' => 'Terjadi kesalahan'])

<div {{ $attributes->merge(['class' => 'rounded-[var(--radius-md)] border border-red-200 bg-red-50 p-4']) }} role="alert">
    <div class="flex gap-3">
        <svg class="h-5 w-5 shrink-0 text-error" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <h4 class="text-sm font-semibold text-error">{{ $title }}</h4>
            @if ($slot->isNotEmpty())
                <p class="mt-1 text-sm text-red-700">{{ $slot }}</p>
            @endif
        </div>
    </div>
</div>
