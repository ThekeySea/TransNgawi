@props(['seats', 'occupied', 'maxSeats' => 1])

<div x-data="seatMap({{ $maxSeats }}, @js($occupied))">
    <div class="mb-6 flex flex-wrap gap-4 text-sm">
        <span class="flex items-center gap-2"><span class="h-4 w-4 rounded border border-border bg-surface-elevated"></span> Tersedia</span>
        <span class="flex items-center gap-2"><span class="h-4 w-4 rounded bg-brand"></span> Dipilih</span>
        <span class="flex items-center gap-2"><span class="h-4 w-4 rounded bg-neutral-300"></span> Terisi</span>
    </div>

    <div class="mx-auto max-w-xs">
        <p class="mb-4 text-center text-xs font-semibold uppercase tracking-wide text-text-subtle">Depan Bus</p>
        <div class="grid grid-cols-4 gap-2">
            @foreach ($seats as $seat)
                <button
                    type="button"
                    @click="toggle('{{ $seat['id'] }}')"
                    :disabled="isOccupied('{{ $seat['id'] }}')"
                    :class="{
                        'bg-brand text-white border-brand': isSelected('{{ $seat['id'] }}'),
                        'bg-neutral-200 text-neutral-500 cursor-not-allowed': isOccupied('{{ $seat['id'] }}'),
                        'bg-surface-elevated border-border hover:border-brand': !isSelected('{{ $seat['id'] }}') && !isOccupied('{{ $seat['id'] }}')
                    }"
                    class="flex h-10 items-center justify-center rounded-[var(--radius-sm)] border text-xs font-semibold transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-brand"
                    aria-label="Kursi {{ $seat['id'] }}"
                >
                    {{ $seat['id'] }}
                </button>
            @endforeach
        </div>
    </div>

    <p class="mt-4 text-center text-sm text-text-muted">
        <span x-text="selected.length"></span> dari {{ $maxSeats }} kursi dipilih
    </p>

    <template x-for="seatId in selected" :key="seatId">
        <input type="hidden" name="seats[]" :value="seatId">
    </template>
</div>
