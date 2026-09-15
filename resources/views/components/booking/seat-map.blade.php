@props(['seats', 'occupied' => [], 'seatStatuses' => [], 'maxSeats' => 1, 'busModel' => 'PLETON', 'preview' => false])

@php
    $rows = collect($seats)->groupBy(fn ($s) => $s['id'][0]);
    $resolvedModel = in_array($busModel, ['BIASANE', 'ANTIBU_SATSET'])
        ? ($busModel === 'BIASANE' ? 'PLETON' : 'KSATRIA')
        : $busModel;
    $is3Col = $resolvedModel === 'KSATRIA';

    $seatLookup = collect($seats)->keyBy('id');

    $previewOccupied = $preview ? ['A1', 'D2'] : [];

    $blockedSeats = collect($seats)
        ->filter(fn ($s) => ($s['status'] ?? '') === 'BLOCKED')
        ->pluck('id')
        ->values()
        ->all();

    $soldSeats = collect($seats)
        ->filter(fn ($s) => in_array(($s['status'] ?? ''), ['SOLD', 'HELD']))
        ->pluck('id')
        ->values()
        ->all();

    $fills = [
        'AVAILABLE' => [
            'Sukian'    => ['back' => '#34D399', 'cushion' => '#34D399', 'arm' => '#059669', 'leg' => '#059669'],
            'SukianPlus'=> ['back' => '#60A5FA', 'cushion' => '#60A5FA', 'arm' => '#2563EB', 'leg' => '#2563EB'],
            'SukianPro' => ['body' => '#A78BFA', 'window' => '#C4B5FD', 'mattress' => '#C4B5FD'],
        ],
        'BLOCKED' => [
            'Sukian'    => ['back' => '#DC2626', 'cushion' => '#DC2626', 'arm' => '#B91C1C', 'leg' => '#B91C1C'],
            'SukianPlus'=> ['back' => '#DC2626', 'cushion' => '#DC2626', 'arm' => '#B91C1C', 'leg' => '#B91C1C'],
            'SukianPro' => ['body' => '#DC2626', 'window' => '#FCA5A5', 'mattress' => '#FCA5A5'],
        ],
        'OCCUPIED' => [
            'Sukian'    => ['back' => '#D1D5DB', 'cushion' => '#D1D5DB', 'arm' => '#9CA3AF', 'leg' => '#9CA3AF'],
            'SukianPlus'=> ['back' => '#D1D5DB', 'cushion' => '#D1D5DB', 'arm' => '#9CA3AF', 'leg' => '#9CA3AF'],
            'SukianPro' => ['body' => '#D1D5DB', 'window' => '#C4C5C3', 'mattress' => '#C4C5C3'],
        ],
        'SELECTED' => [
            'Sukian'    => ['back' => '#FFFFFF', 'cushion' => '#FFFFFF', 'arm' => '#FFFFFF', 'leg' => '#FFFFFF'],
            'SukianPlus'=> ['back' => '#FFFFFF', 'cushion' => '#FFFFFF', 'arm' => '#FFFFFF', 'leg' => '#FFFFFF'],
            'SukianPro' => ['body' => '#FFFFFF', 'window' => '#FFFFFF', 'mattress' => '#FFFFFF'],
        ],
    ];
@endphp

<div class="mx-auto max-w-md" x-data="seatMap({{ $maxSeats }}, {{ json_encode($occupied) }}, {{ json_encode($blockedSeats) }})">
    {{-- ── Bus Cabin ── --}}
    <div class="bus-cabin">
        <div class="bus-windshield">
            <div class="h-px flex-1 bg-gradient-to-r from-transparent via-neutral-300 to-transparent"></div>
        </div>

        <div class="bus-driver">
            <svg class="driver-wheel" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="12" cy="12" r="9"/>
                <circle cx="12" cy="12" r="3"/>
                <line x1="12" y1="3" x2="12" y2="9"/>
                <line x1="12" y1="15" x2="12" y2="21"/>
                <line x1="3" y1="12" x2="9" y2="12"/>
                <line x1="15" y1="12" x2="21" y2="12"/>
            </svg>
        </div>

        @php
            $currentClass = null;
            $allRows = $rows->all();
        @endphp

        @foreach ($allRows as $rowLabel => $rowSeats)
            @php
                $seatData = $seatLookup->get($rowLabel . 1);
                $rowClass = $seatData['class'] ?? 'Sukian';
                $isFirst = $loop->first;

                $colCount = count($rowSeats);

                $sectionChanged = $rowClass !== $currentClass;
            @endphp

            @if ($sectionChanged && ! $isFirst)
                <div class="section-divider"></div>
            @endif

            <div class="seat-row" data-class="{{ $rowClass }}">
                <span class="row-num">{{ $rowLabel }}</span>

                @for ($col = 1; $col <= $colCount; $col++)
                    @php
                        $seatId = $rowLabel . $col;
                        $seatData = $seatLookup->get($seatId);
                    @endphp

                    @if (! $seatData)
                        @continue
                    @endif

                    @php
                        $isOccupiedServer = in_array($seatId, $occupied) || in_array($seatId, $previewOccupied);
                        $className = $seatData['class'] ?? 'Sukian';
                        $isSleeper = $className === 'SukianPro';
                        $seatStatus = $seatStatuses[$seatId] ?? ($isOccupiedServer ? 'OCCUPIED' : 'AVAILABLE');
                        $isBlocked = ($seatData['status'] ?? '') === 'BLOCKED' || $seatStatus === 'BLOCKED';
                    @endphp

                    @if ($colCount === 4 && $col === 3)
                        <div class="aisle-wide"></div>
                    @endif
                    @if ($colCount === 2 && $col === 2)
                        <div class="aisle-wide"></div>
                    @endif

                    @if ($preview)
                        @php
                            if ($isBlocked) {
                                $f = $fills['BLOCKED'][$className];
                            } elseif ($isOccupiedServer) {
                                $f = $fills['OCCUPIED'][$className];
                            } else {
                                $f = $fills['AVAILABLE'][$className];
                            }
                        @endphp
                        <div class="seat-icon seat-icon--{{ strtolower($className) }} {{ $isBlocked ? 'seat-icon--blocked seat-icon--occupied' : ($isOccupiedServer ? 'seat-icon--occupied' : '') }}">
                            {{-- SukianPro: Capsule/Pod --}}
                            @if ($className === 'SukianPro')
                                <svg viewBox="0 0 28 36" fill="none" class="seat-svg">
                                    <rect x="2" y="2" width="24" height="32" rx="5" fill="{{ $f['body'] }}"/>
                                    <rect x="5" y="5" width="18" height="10" rx="3" fill="{{ $f['window'] }}"/>
                                    <rect x="5" y="20" width="18" height="8" rx="3" fill="{{ $f['mattress'] }}"/>
                                </svg>
                            {{-- SukianPlus: Wide Recliner --}}
                            @elseif ($className === 'SukianPlus')
                                <svg viewBox="0 0 36 32" fill="none" class="seat-svg seat-svg--wide">
                                    <rect x="2" y="2" width="32" height="12" rx="4" fill="{{ $f['back'] }}"/>
                                    <rect x="4" y="3" width="12" height="4" rx="2" fill="{{ $f['cushion'] }}" opacity="0.5"/>
                                    <rect x="4" y="14" width="28" height="8" rx="3" fill="{{ $f['cushion'] }}"/>
                                    <rect x="0" y="14" width="5" height="10" rx="2" fill="{{ $f['arm'] }}"/>
                                    <rect x="31" y="14" width="5" height="10" rx="2" fill="{{ $f['arm'] }}"/>
                                    <rect x="6" y="22" width="4" height="5" rx="1.5" fill="{{ $f['leg'] }}"/>
                                    <rect x="26" y="22" width="4" height="5" rx="1.5" fill="{{ $f['leg'] }}"/>
                                </svg>
                            {{-- Sukian: Standard Chair --}}
                            @else
                                <svg viewBox="0 0 32 32" fill="none" class="seat-svg">
                                    <rect x="4" y="2" width="24" height="11" rx="3" fill="{{ $f['back'] }}"/>
                                    <rect x="6" y="13" width="20" height="8" rx="2" fill="{{ $f['cushion'] }}"/>
                                    <rect x="2" y="13" width="4" height="9" rx="1.5" fill="{{ $f['arm'] }}"/>
                                    <rect x="26" y="13" width="4" height="9" rx="1.5" fill="{{ $f['arm'] }}"/>
                                    <rect x="8" y="21" width="3" height="5" rx="1" fill="{{ $f['leg'] }}"/>
                                    <rect x="21" y="21" width="3" height="5" rx="1" fill="{{ $f['leg'] }}"/>
                                </svg>
                            @endif
                            <span class="seat-label">{{ $seatId }}</span>
                        </div>
                    @else
                        <button
                            type="button"
                            @click="toggle('{{ $seatId }}')"
                            :disabled="isOccupied('{{ $seatId }}') || isBlocked('{{ $seatId }}')"
                            :class="{
                                'seat-icon--selected': isSelected('{{ $seatId }}'),
                                'seat-icon--occupied': (isOccupied('{{ $seatId }}') && !isBlocked('{{ $seatId }}')),
                                'seat-icon--blocked': isBlocked('{{ $seatId }}'),
                                'seat-icon--{{ strtolower($className) }}': !isSelected('{{ $seatId }}') && !isOccupied('{{ $seatId }}') && !isBlocked('{{ $seatId }}')
                            }"
                            class="seat-icon customer-seat"
                            data-seat="{{ $seatId }}"
                            data-class="{{ $className }}"
                            data-status="{{ $seatData['status'] ?? 'AVAILABLE' }}"
                            :aria-label="'Kursi {{ $seatId }} — {{ $className }}' + (isBlocked('{{ $seatId }}') ? ' (rusak / non-aktif)' : (isOccupied('{{ $seatId }}') ? ' (terisi)' : ''))"
                            :title="isBlocked('{{ $seatId }}') ? 'Kursi Dalam Perbaikan / Non-aktif' : '{{ $className }}'"
                        >
                            {{-- SukianPro: Capsule/Pod --}}
                            @if ($className === 'SukianPro')
                                <svg viewBox="0 0 28 36" fill="none" class="seat-svg">
                                    <rect x="2" y="2" width="24" height="32" rx="5"
                                        :fill="isBlocked('{{ $seatId }}') ? '#DC2626' : (isOccupied('{{ $seatId }}') ? '#D1D5DB' : (isSelected('{{ $seatId }}') ? '#FFFFFF' : '#A78BFA'))"/>
                                    <rect x="5" y="5" width="18" height="10" rx="3"
                                        :fill="isBlocked('{{ $seatId }}') ? '#FCA5A5' : (isOccupied('{{ $seatId }}') ? '#C4C5C3' : (isSelected('{{ $seatId }}') ? '#FFFFFF' : '#C4B5FD'))"/>
                                    <rect x="5" y="20" width="18" height="8" rx="3"
                                        :fill="isBlocked('{{ $seatId }}') ? '#FCA5A5' : (isOccupied('{{ $seatId }}') ? '#C4C5C3' : (isSelected('{{ $seatId }}') ? '#FFFFFF' : '#C4B5FD'))"/>
                                </svg>
                            {{-- SukianPlus: Wide Recliner --}}
                            @elseif ($className === 'SukianPlus')
                                @php
                                    $defaultBack = '#60A5FA';
                                    $defaultCushion = '#60A5FA';
                                    $defaultArm = '#2563EB';
                                    $defaultLeg = '#2563EB';
                                @endphp
                                <svg viewBox="0 0 36 32" fill="none" class="seat-svg seat-svg--wide">
                                    <rect x="2" y="2" width="32" height="12" rx="4"
                                        :fill="isBlocked('{{ $seatId }}') ? '#DC2626' : (isOccupied('{{ $seatId }}') ? '#D1D5DB' : (isSelected('{{ $seatId }}') ? '#FFFFFF' : '{{ $defaultBack }}'))"/>
                                    <rect x="4" y="3" width="12" height="4" rx="2"
                                        :fill="isBlocked('{{ $seatId }}') ? '#DC2626' : (isOccupied('{{ $seatId }}') ? '#D1D5DB' : (isSelected('{{ $seatId }}') ? '#FFFFFF' : '{{ $defaultCushion }}')" opacity="0.5"/>
                                    <rect x="4" y="14" width="28" height="8" rx="3"
                                        :fill="isBlocked('{{ $seatId }}') ? '#DC2626' : (isOccupied('{{ $seatId }}') ? '#D1D5DB' : (isSelected('{{ $seatId }}') ? '#FFFFFF' : '{{ $defaultCushion }}'))"/>
                                    <rect x="0" y="14" width="5" height="10" rx="2"
                                        :fill="isBlocked('{{ $seatId }}') ? '#B91C1C' : (isOccupied('{{ $seatId }}') ? '#9CA3AF' : (isSelected('{{ $seatId }}') ? '#FFFFFF' : '{{ $defaultArm }}'))"/>
                                    <rect x="31" y="14" width="5" height="10" rx="2"
                                        :fill="isBlocked('{{ $seatId }}') ? '#B91C1C' : (isOccupied('{{ $seatId }}') ? '#9CA3AF' : (isSelected('{{ $seatId }}') ? '#FFFFFF' : '{{ $defaultArm }}'))"/>
                                    <rect x="6" y="22" width="4" height="5" rx="1.5"
                                        :fill="isBlocked('{{ $seatId }}') ? '#B91C1C' : (isOccupied('{{ $seatId }}') ? '#9CA3AF' : (isSelected('{{ $seatId }}') ? '#FFFFFF' : '{{ $defaultLeg }}'))"/>
                                    <rect x="26" y="22" width="4" height="5" rx="1.5"
                                        :fill="isBlocked('{{ $seatId }}') ? '#B91C1C' : (isOccupied('{{ $seatId }}') ? '#9CA3AF' : (isSelected('{{ $seatId }}') ? '#FFFFFF' : '{{ $defaultLeg }}'))"/>
                                </svg>
                            {{-- Sukian: Standard Chair --}}
                            @else
                                @php
                                    $defaultBack = '#34D399';
                                    $defaultCushion = '#34D399';
                                    $defaultArm = '#059669';
                                    $defaultLeg = '#059669';
                                @endphp
                                <svg viewBox="0 0 32 32" fill="none" class="seat-svg">
                                    <rect x="4" y="2" width="24" height="11" rx="3"
                                        :fill="isBlocked('{{ $seatId }}') ? '#DC2626' : (isOccupied('{{ $seatId }}') ? '#D1D5DB' : (isSelected('{{ $seatId }}') ? '#FFFFFF' : '{{ $defaultBack }}'))"/>
                                    <rect x="6" y="13" width="20" height="8" rx="2"
                                        :fill="isBlocked('{{ $seatId }}') ? '#DC2626' : (isOccupied('{{ $seatId }}') ? '#D1D5DB' : (isSelected('{{ $seatId }}') ? '#FFFFFF' : '{{ $defaultCushion }}'))"/>
                                    <rect x="2" y="13" width="4" height="9" rx="1.5"
                                        :fill="isBlocked('{{ $seatId }}') ? '#B91C1C' : (isOccupied('{{ $seatId }}') ? '#9CA3AF' : (isSelected('{{ $seatId }}') ? '#FFFFFF' : '{{ $defaultArm }}'))"/>
                                    <rect x="26" y="13" width="4" height="9" rx="1.5"
                                        :fill="isBlocked('{{ $seatId }}') ? '#B91C1C' : (isOccupied('{{ $seatId }}') ? '#9CA3AF' : (isSelected('{{ $seatId }}') ? '#FFFFFF' : '{{ $defaultArm }}'))"/>
                                    <rect x="8" y="21" width="3" height="5" rx="1"
                                        :fill="isBlocked('{{ $seatId }}') ? '#B91C1C' : (isOccupied('{{ $seatId }}') ? '#9CA3AF' : (isSelected('{{ $seatId }}') ? '#FFFFFF' : '{{ $defaultLeg }}'))"/>
                                    <rect x="21" y="21" width="3" height="5" rx="1"
                                        :fill="isBlocked('{{ $seatId }}') ? '#B91C1C' : (isOccupied('{{ $seatId }}') ? '#9CA3AF' : (isSelected('{{ $seatId }}') ? '#FFFFFF' : '{{ $defaultLeg }}'))"/>
                                </svg>
                            @endif
                            <span class="seat-label" x-text="isSelected('{{ $seatId }}') ? '✓' : '{{ $seatId }}'"></span>
                        </button>
                    @endif
                @endfor
            </div>

            @php $currentClass = $rowClass; @endphp
        @endforeach

        <div class="bus-rear"></div>
    </div>

    <div class="mt-4 flex flex-wrap items-center justify-center gap-x-5 gap-y-2 text-xs text-text-muted">
        <span class="legend-dot legend-dot--standard"></span> Sukian
        <span class="legend-dot legend-dot--plus"></span> SukianPlus
        @if ($is3Col)
            <span class="legend-dot legend-dot--pro"></span> SukianPro
        @endif
        <span class="legend-dot legend-dot--selected"></span> Dipilih
        <span class="legend-dot legend-dot--occupied"></span> Terisi
        <span class="legend-dot legend-dot--blocked"></span> Rusak
    </div>

    <p class="mt-3 text-center text-sm text-text-muted">
        <span x-text="selected.length"></span> dari {{ $maxSeats }} kursi dipilih
    </p>

    <template x-for="seatId in selected" :key="seatId">
        <input type="hidden" name="seats[]" :value="seatId">
    </template>
</div>
