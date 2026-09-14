@props(['trip'])

<article class="card overflow-hidden transition-shadow hover:shadow-md">
    <div class="card-body">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex-1">
                <div class="mb-2 flex flex-wrap items-center gap-2">
                    <span class="badge-info">{{ $trip['service'] }}</span>
                    <span class="text-sm text-text-muted">{{ $trip['duration'] }}</span>
                </div>

                <h3 class="text-xl font-bold text-text">
                    {{ $trip['origin'] }}
                    <span class="mx-2 text-brand" aria-hidden="true">→</span>
                    {{ $trip['destination'] }}
                </h3>

                <div class="mt-3 flex flex-wrap gap-6 text-sm">
                    <div>
                        <span class="text-text-subtle">Berangkat</span>
                        <p class="font-semibold text-text">{{ $trip['departure'] }}</p>
                    </div>
                    <div>
                        <span class="text-text-subtle">Tiba</span>
                        <p class="font-semibold text-text">{{ $trip['arrival'] }}</p>
                    </div>
                    <div>
                        <span class="text-text-subtle">Kelas</span>
                        <p class="font-semibold text-text">{{ $trip['class'] }}</p>
                    </div>
                </div>

                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach ($trip['facilities'] as $facility)
                        <span class="rounded-full bg-surface px-2.5 py-1 text-xs font-medium text-text-muted">{{ $facility }}</span>
                    @endforeach
                </div>
            </div>

            <div class="flex flex-col items-start gap-3 border-t border-border pt-4 lg:min-w-[180px] lg:border-t-0 lg:border-l lg:pl-6 lg:pt-0">
                <div>
                    <p class="text-sm text-text-subtle">Mulai dari</p>
                    <p class="text-2xl font-bold text-text">Rp {{ number_format($trip['price'], 0, ',', '.') }}</p>
                    <p class="text-xs text-text-muted">{{ $trip['seats_available'] }} kursi tersedia</p>
                </div>
                <x-ui.button href="{{ route('trips.show', $trip['id']) }}" class="w-full lg:w-auto">Pilih</x-ui.button>
            </div>
        </div>
    </div>
</article>
