@props(['classData', 'selected' => false, 'fare' => null])

<div @class([
    'card cursor-pointer transition-all',
    'ring-2 ring-brand border-brand' => $selected,
    'hover:shadow-md' => ! $selected,
])>
    <div class="card-body">
        <h3 class="text-lg font-bold text-text">{{ $classData['name'] }}</h3>
        <p class="mt-2 text-sm text-text-muted">{{ $classData['description'] }}</p>

        @if ($fare)
            <p class="mt-4 text-xl font-bold text-text">Rp {{ number_format($fare['price'], 0, ',', '.') }}</p>
            <p class="text-xs text-text-muted">{{ $fare['available'] }} kursi tersedia</p>
        @endif

        <ul class="mt-4 space-y-1.5">
            @foreach ($classData['facilities'] as $facility)
                <li class="flex items-center gap-2 text-sm text-text-muted">
                    <svg class="h-4 w-4 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ $facility }}
                </li>
            @endforeach
        </ul>

        {{ $slot }}
    </div>
</div>
