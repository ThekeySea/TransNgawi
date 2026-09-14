@props(['seats', 'occupied', 'maxSeats' => 1, 'busModel' => 'BIASANE'])

@php
    // Group seats by row for layout
    $rows = collect($seats)->groupBy(fn ($s) => $s['id'][0]);
    $colCount = $busModel === 'ANTIBU_SATSET' ? 3 : 4;

    // Class-specific shapes/symbols
    $classSymbols = [
        'Sukian' => '◻',
        'SukianPlus' => '◈',
        'SukianPro' => '◆',
    ];

    // Class-specific colors
    $classColors = [
        'Sukian' => 'bg-emerald-50 border-emerald-300 text-emerald-700',
        'SukianPlus' => 'bg-blue-50 border-blue-300 text-blue-700',
        'SukianPro' => 'bg-purple-50 border-purple-300 text-purple-700',
    ];

    // Build seat lookup for quick access
    $seatLookup = collect($seats)->keyBy('id');
@endphp

<div x-data="seatMap({{ $maxSeats }}, @js($occupied))">
    {{-- Legend --}}
    <div class="mb-6 flex flex-wrap gap-4 text-sm">
        <span class="flex items-center gap-2">
            <span class="flex h-6 w-6 items-center justify-center rounded border border-emerald-300 bg-emerald-50 text-[10px]">◻</span>
            Sukian
        </span>
        <span class="flex items-center gap-2">
            <span class="flex h-6 w-6 items-center justify-center rounded border border-blue-300 bg-blue-50 text-[10px]">◈</span>
            SukianPlus
        </span>
        <span class="flex items-center gap-2">
            <span class="flex h-6 w-6 items-center justify-center rounded border border-purple-300 bg-purple-50 text-[10px]">◆</span>
            SukianPro
        </span>
        <span class="flex items-center gap-2">
            <span class="h-4 w-4 rounded bg-[#ff750f]"></span>
            Dipilih
        </span>
        <span class="flex items-center gap-2">
            <span class="h-4 w-4 rounded bg-neutral-300"></span>
            Terisi
        </span>
    </div>

    {{-- Bus Layout --}}
    <div class="mx-auto max-w-sm">
        <p class="mb-4 text-center text-xs font-semibold uppercase tracking-wide text-text-subtle">Depan Bus</p>

        {{-- Driver icon --}}
        <div class="mb-4 flex justify-center">
            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-neutral-100 text-xs text-text-subtle">
                🚌
            </div>
        </div>

        {{-- Seats --}}
        <div class="space-y-2">
            @foreach ($rows as $rowLabel => $rowSeats)
                <div class="flex items-center justify-center gap-1.5">
                    <span class="w-5 text-center text-xs font-bold text-text-subtle">{{ $rowLabel }}</span>

                    @if ($busModel === 'ANTIBU_SATSET')
                        {{-- ANTIBU_SATSET: 1-1-1 layout with aisle --}}
                        @for ($col = 1; $col <= $colCount; $col++)
                            @php
                                $seatId = $rowLabel . $col;
                                $seatData = $seatLookup->get($seatId);
                                $isOccupied = in_array($seatId, $occupied);
                                $className = $seatData['class'] ?? 'Sukian';
                            @endphp

                            @if ($col === 2)
                                <div class="w-4"></div>
                            @endif

                            <button
                                type="button"
                                @click="toggle('{{ $seatId }}')"
                                :disabled="isOccupied('{{ $seatId }}')"
                                :class="{
                                    'bg-[#ff750f] text-white border-[#ff750f]': isSelected('{{ $seatId }}'),
                                    'bg-neutral-200 text-neutral-500 cursor-not-allowed opacity-60': isOccupied('{{ $seatId }}'),
                                    '{{ $classColors[$className] ?? 'bg-surface-elevated border-border' }}': !isSelected('{{ $seatId }}') && !isOccupied('{{ $seatId }}')
                                }"
                                class="flex h-9 w-9 items-center justify-center rounded border text-[10px] font-semibold transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-brand hover:scale-105 disabled:hover:scale-100"
                                aria-label="Kursi {{ $seatId }}{{ $isOccupied ? ' (terisi)' : '' }}"
                                title="{{ $className }}"
                            >
                                {{ $seatId }}
                            </button>
                        @endfor
                    @else
                        {{-- BIASANE: 2-2 layout with aisle --}}
                        @for ($col = 1; $col <= $colCount; $col++)
                            @php
                                $seatId = $rowLabel . $col;
                                $seatData = $seatLookup->get($seatId);
                                $isOccupied = in_array($seatId, $occupied);
                                $className = $seatData['class'] ?? 'Sukian';
                            @endphp

                            @if ($col === 3)
                                <div class="w-4"></div>
                            @endif

                            <button
                                type="button"
                                @click="toggle('{{ $seatId }}')"
                                :disabled="isOccupied('{{ $seatId }}')"
                                :class="{
                                    'bg-[#ff750f] text-white border-[#ff750f]': isSelected('{{ $seatId }}'),
                                    'bg-neutral-200 text-neutral-500 cursor-not-allowed opacity-60': isOccupied('{{ $seatId }}'),
                                    '{{ $classColors[$className] ?? 'bg-surface-elevated border-border' }}': !isSelected('{{ $seatId }}') && !isOccupied('{{ $seatId }}')
                                }"
                                class="flex h-9 w-9 items-center justify-center rounded border text-[10px] font-semibold transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-brand hover:scale-105 disabled:hover:scale-100"
                                aria-label="Kursi {{ $seatId }}{{ $isOccupied ? ' (terisi)' : '' }}"
                                title="{{ $className }}"
                            >
                                {{ $seatId }}
                            </button>
                        @endfor
                    @endif
                </div>
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
