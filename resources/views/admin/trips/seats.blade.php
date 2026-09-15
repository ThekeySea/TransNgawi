@extends('layouts.admin')

@section('title', 'Kursi Trip — ' . $trip->route->origin->name . ' → ' . $trip->route->destination->name)

@section('content')
    <div class="container-app">
        {{-- Header --}}
        <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
            <div class="max-w-2xl">
                <div class="flex items-center gap-2 text-sm text-[#555555]">
                    <a href="{{ route('admin.trips.index') }}" class="hover:text-[#ff750f] transition-colors">Trip</a>
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="font-semibold text-[#1a1a1a]">{{ $trip->route->origin->name }} → {{ $trip->route->destination->name }}</span>
                </div>
                <h1 class="mt-2 text-3xl font-bold tracking-tight">Live Seat Monitoring</h1>
                <p class="mt-2 text-base text-[#555555]">
                    {{ $trip->bus->plate_number }} ({{ $trip->bus->model_type->label() }}) ·
                    {{ $trip->departs_at->format('d M Y H:i') }}
                </p>
            </div>
        </div>

        @if (session('status'))
            <div class="mb-4 rounded-[var(--radius-sm)] border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 rounded-[var(--radius-sm)] border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>
        @endif

        {{-- Stats Bar --}}
        <div class="mb-6 grid grid-cols-2 gap-3 sm:grid-cols-5">
            <div class="rounded-[var(--radius-sm)] border border-[#e6e6e6] bg-white p-4">
                <p class="text-[10px] font-semibold uppercase tracking-wider text-[#555555]">Total</p>
                <p class="mt-1 text-2xl font-bold text-[#1a1a1a]" id="stat-total">{{ $stats['total'] }}</p>
            </div>
            <div class="rounded-[var(--radius-sm)] border border-emerald-200 bg-emerald-50 p-4">
                <p class="text-[10px] font-semibold uppercase tracking-wider text-emerald-700">Tersedia</p>
                <p class="mt-1 text-2xl font-bold text-emerald-700" id="stat-available">{{ $stats['available'] }}</p>
            </div>
            <div class="rounded-[var(--radius-sm)] border border-amber-200 bg-amber-50 p-4">
                <p class="text-[10px] font-semibold uppercase tracking-wider text-amber-700">Ditahan</p>
                <p class="mt-1 text-2xl font-bold text-amber-700" id="stat-held">{{ $stats['held'] }}</p>
            </div>
            <div class="rounded-[var(--radius-sm)] border border-neutral-200 bg-neutral-50 p-4">
                <p class="text-[10px] font-semibold uppercase tracking-wider text-neutral-600">Terjual</p>
                <p class="mt-1 text-2xl font-bold text-neutral-700" id="stat-sold">{{ $stats['sold'] }}</p>
            </div>
            <div class="rounded-[var(--radius-sm)] border border-red-200 bg-red-50 p-4">
                <p class="text-[10px] font-semibold uppercase tracking-wider text-red-700">Rusak</p>
                <p class="mt-1 text-2xl font-bold text-red-700" id="stat-blocked">{{ $stats['blocked'] }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            {{-- Seat Map --}}
            <div class="lg:col-span-2">
                <div class="card">
                    <div class="card-body">
                        <h2 class="mb-4 text-base font-bold text-[#1a1a1a]">Peta Kursi Langsung</h2>

                        <div class="mx-auto max-w-md">
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
                                    $seatLookup = collect($seats)->keyBy('id');
                                    $rows = collect($seats)->groupBy(fn ($s) => $s['id'][0]);
                                    $currentClass = null;
                                    $allRows = $rows->all();

                                    $sleeperFills = [
                                        'AVAILABLE' => ['body' => '#A78BFA', 'window' => '#C4B5FD', 'mattress' => '#C4B5FD'],
                                        'HELD' => ['body' => '#FBBF24', 'window' => '#FDE68A', 'mattress' => '#FDE68A'],
                                        'SOLD' => ['body' => '#6B7280', 'window' => '#9CA3AF', 'mattress' => '#9CA3AF'],
                                        'BLOCKED' => ['body' => '#DC2626', 'window' => '#FCA5A5', 'mattress' => '#FCA5A5'],
                                    ];

                                    $seaterFills = [
                                        'AVAILABLE_Sukian' => ['back' => '#34D399', 'arm' => '#059669'],
                                        'AVAILABLE_SukianPlus' => ['back' => '#60A5FA', 'arm' => '#2563EB'],
                                        'HELD_Sukian' => ['back' => '#FBBF24', 'arm' => '#D97706'],
                                        'HELD_SukianPlus' => ['back' => '#FBBF24', 'arm' => '#D97706'],
                                        'SOLD_Sukian' => ['back' => '#6B7280', 'arm' => '#4B5563'],
                                        'SOLD_SukianPlus' => ['back' => '#6B7280', 'arm' => '#4B5563'],
                                        'BLOCKED_Sukian' => ['back' => '#DC2626', 'arm' => '#B91C1C'],
                                        'BLOCKED_SukianPlus' => ['back' => '#DC2626', 'arm' => '#B91C1C'],
                                    ];
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
                                                $seatInfo = $seatLookup->get($seatId);
                                            @endphp

                                            @if (! $seatInfo)
                                                <div class="aisle-wide"></div>
                                                @continue
                                            @endif

                                            @php
                                                $seatStatus = $seatInfo['status'] ?? 'AVAILABLE';
                                                $className = $seatInfo['class'] ?? 'Sukian';
                                                $isSleeper = $className === 'SukianPro';

                                                $statusLabel = match($seatStatus) {
                                                    'AVAILABLE' => 'Tersedia',
                                                    'HELD' => 'Ditahan (checkout)',
                                                    'SOLD' => 'Terjual',
                                                    'BLOCKED' => 'Rusak / Maintenance',
                                                    default => $seatStatus,
                                                };

                                                if ($isSleeper) {
                                                    $sf = $sleeperFills[$seatStatus] ?? $sleeperFills['AVAILABLE'];
                                                } else {
                                                    $sf = $seaterFills[$seatStatus . '_' . $className] ?? $seaterFills['AVAILABLE_' . $className];
                                                }
                                            @endphp

                                            @if ($colCount === 4 && $col === 3)
                                                <div class="aisle-wide"></div>
                                            @endif
                                            @if ($colCount === 2 && $col === 2)
                                                <div class="aisle-wide"></div>
                                            @endif

                                            <form action="{{ route('admin.trip-seats.toggle', $seatInfo['id']) }}" method="POST" id="seat-form-{{ $seatId }}">
                                                @csrf
                                                @method('PATCH')
                                                <button
                                                    type="button"
                                                    id="seat-btn-{{ $seatId }}"
                                                    data-seat="{{ $seatId }}"
                                                    data-class="{{ $className }}"
                                                    data-status="{{ $seatStatus }}"
                                                    data-form="seat-form-{{ $seatId }}"
                                                    onclick="handleSeatClick(this)"
                                                    class="seat-icon admin-seat
                                                        @if($seatStatus === 'AVAILABLE') seat-icon--{{ strtolower($className) }}
                                                        @elseif($seatStatus === 'HELD') seat-icon--held
                                                        @elseif($seatStatus === 'SOLD') seat-icon--sold
                                                        @elseif($seatStatus === 'BLOCKED') seat-icon--blocked
                                                        @endif"
                                                    title="{{ $className }} — {{ $statusLabel }}"
                                                >
                                                    {{-- SukianPro: Capsule/Pod --}}
                                                    @if ($className === 'SukianPro')
                                                        <svg viewBox="0 0 28 36" fill="none" class="seat-svg">
                                                            <rect x="2" y="2" width="24" height="32" rx="5" fill="{{ $sf['body'] }}"/>
                                                            <rect x="5" y="5" width="18" height="10" rx="3" fill="{{ $sf['window'] }}"/>
                                                            <rect x="5" y="20" width="18" height="8" rx="3" fill="{{ $sf['mattress'] }}"/>
                                                            @if ($seatStatus === 'BLOCKED')
                                                                <text x="14" y="22" text-anchor="middle" fill="white" font-size="10" font-weight="bold">⚠</text>
                                                            @endif
                                                        </svg>
                                                    {{-- SukianPlus: Wide Recliner --}}
                                                    @elseif ($className === 'SukianPlus')
                                                        <svg viewBox="0 0 36 32" fill="none" class="seat-svg seat-svg--wide">
                                                            <rect x="2" y="2" width="32" height="12" rx="4" fill="{{ $sf['back'] }}"/>
                                                            <rect x="4" y="3" width="12" height="4" rx="2" fill="{{ $sf['back'] }}" opacity="0.5"/>
                                                            <rect x="4" y="14" width="28" height="8" rx="3" fill="{{ $sf['back'] }}"/>
                                                            <rect x="0" y="14" width="5" height="10" rx="2" fill="{{ $sf['arm'] }}"/>
                                                            <rect x="31" y="14" width="5" height="10" rx="2" fill="{{ $sf['arm'] }}"/>
                                                            <rect x="6" y="22" width="4" height="5" rx="1.5" fill="{{ $sf['arm'] }}"/>
                                                            <rect x="26" y="22" width="4" height="5" rx="1.5" fill="{{ $sf['arm'] }}"/>
                                                            @if ($seatStatus === 'BLOCKED')
                                                                <text x="18" y="18" text-anchor="middle" fill="white" font-size="10" font-weight="bold">⚠</text>
                                                            @endif
                                                        </svg>
                                                    {{-- Sukian: Standard Chair --}}
                                                    @else
                                                        <svg viewBox="0 0 32 32" fill="none" class="seat-svg">
                                                            <rect x="4" y="2" width="24" height="11" rx="3" fill="{{ $sf['back'] }}"/>
                                                            <rect x="6" y="13" width="20" height="8" rx="2" fill="{{ $sf['back'] }}"/>
                                                            <rect x="2" y="13" width="4" height="9" rx="1.5" fill="{{ $sf['arm'] }}"/>
                                                            <rect x="26" y="13" width="4" height="9" rx="1.5" fill="{{ $sf['arm'] }}"/>
                                                            <rect x="8" y="21" width="3" height="5" rx="1" fill="{{ $sf['arm'] }}"/>
                                                            <rect x="21" y="21" width="3" height="5" rx="1" fill="{{ $sf['arm'] }}"/>
                                                            @if ($seatStatus === 'BLOCKED')
                                                                <text x="16" y="18" text-anchor="middle" fill="white" font-size="10" font-weight="bold">⚠</text>
                                                            @endif
                                                        </svg>
                                                    @endif
                                                    <span class="seat-label">{{ $seatStatus === 'BLOCKED' ? '⚠' : $seatId }}</span>
                                                </button>
                                            </form>
                                        @endfor
                                    </div>

                                    @php $currentClass = $rowClass; @endphp
                                @endforeach

                                <div class="bus-rear"></div>
                            </div>
                        </div>

                        {{-- Legend --}}
                        <div class="mt-4 flex flex-wrap items-center justify-center gap-x-5 gap-y-2 text-xs text-[#555555]">
                            <span class="flex items-center gap-1.5">
                                <span class="inline-block h-3 w-3 rounded bg-emerald-500"></span> Tersedia
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="inline-block h-3 w-3 rounded bg-amber-400"></span> Ditahan
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="inline-block h-3 w-3 rounded bg-neutral-500"></span> Terjual
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="inline-block h-3 w-3 rounded bg-red-600"></span> Rusak
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar: Trip Info --}}
            <div class="space-y-5">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-sm font-bold text-[#1a1a1a]">Info Trip</h3>
                        <dl class="mt-3 space-y-2 text-xs">
                            <div class="flex justify-between">
                                <dt class="text-[#555555]">Rute</dt>
                                <dd class="font-semibold text-[#1a1a1a]">{{ $trip->route->origin->name }} → {{ $trip->route->destination->name }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-[#555555]">Bus</dt>
                                <dd class="font-semibold text-[#1a1a1a]">{{ $trip->bus->plate_number }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-[#555555]">Model</dt>
                                <dd class="font-semibold text-[#1a1a1a]">{{ $trip->bus->model_type->label() }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-[#555555]">Berangkat</dt>
                                <dd class="font-semibold text-[#1a1a1a]">{{ $trip->departs_at->format('d M Y H:i') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-[#555555]">Tiba</dt>
                                <dd class="font-semibold text-[#1a1a1a]">{{ $trip->arrives_at->format('d M Y H:i') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h3 class="text-sm font-bold text-[#1a1a1a]">Harga per Kelas</h3>
                        <dl class="mt-3 space-y-2 text-xs">
                            @foreach ($trip->fares as $fare)
                                <div class="flex justify-between">
                                    <dt class="text-[#555555]">{{ $fare->class_name }}</dt>
                                    <dd class="font-semibold text-[#1a1a1a]">Rp {{ number_format($fare->fare_amount, 0, ',', '.') }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                </div>

                <a href="{{ route('admin.trips.edit', $trip) }}" class="btn-secondary block text-center text-sm">Ubah Trip</a>
            </div>
        </div>

        {{-- Toast Container --}}
        <div id="toast-container" class="fixed bottom-6 right-6 z-50 flex flex-col gap-2"></div>

        {{-- Seat Action Modal --}}
        <div id="seat-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4" onclick="if(event.target===this)closeSeatModal()">
            <div class="w-full max-w-sm rounded-2xl bg-white p-6 shadow-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-[#1a1a1a]">Kursi <span id="modal-seat-code"></span></h3>
                    <button onclick="closeSeatModal()" class="rounded-full p-1 text-[#555555] hover:bg-[#e6e6e6] transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="mt-4 space-y-3 text-sm">
                    <div class="flex justify-between rounded-[var(--radius-sm)] bg-[#faf9f8] px-4 py-2.5">
                        <span class="text-[#555555]">Nomor Kursi</span>
                        <span id="modal-seat-number" class="font-bold text-[#1a1a1a]"></span>
                    </div>
                    <div class="flex justify-between rounded-[var(--radius-sm)] bg-[#faf9f8] px-4 py-2.5">
                        <span class="text-[#555555]">Kelas</span>
                        <span id="modal-seat-class" class="font-bold text-[#1a1a1a]"></span>
                    </div>
                    <div class="flex justify-between rounded-[var(--radius-sm)] bg-[#faf9f8] px-4 py-2.5">
                        <span class="text-[#555555]">Status</span>
                        <span id="modal-seat-status" class="font-bold"></span>
                    </div>
                </div>

                <div id="modal-available-action" class="mt-6 hidden">
                    <button onclick="confirmToggle()" class="flex w-full items-center gap-3 rounded-[var(--radius-sm)] border border-red-200 bg-red-50 p-3 text-left text-sm transition-colors hover:bg-red-100">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-red-100 text-red-600">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        </span>
                        <div>
                            <p class="font-semibold text-red-700">Tandai Kursi Rusak / Maintenance</p>
                            <p class="text-xs text-red-500">Kursi tidak dapat dipesan oleh penumpang</p>
                        </div>
                    </button>
                </div>

                <div id="modal-blocked-action" class="mt-6 hidden">
                    <button onclick="confirmToggle()" class="flex w-full items-center gap-3 rounded-[var(--radius-sm)] border border-emerald-200 bg-emerald-50 p-3 text-left text-sm transition-colors hover:bg-emerald-100">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        <div>
                            <p class="font-semibold text-emerald-700">Kembalikan ke Kondisi Normal</p>
                            <p class="text-xs text-emerald-500">Kursi tersedia kembali untuk dipesan</p>
                        </div>
                    </button>
                </div>

                <div id="modal-protected-action" class="mt-6 hidden">
                    <div class="rounded-[var(--radius-sm)] bg-[#faf9f8] p-4 text-center text-sm text-[#555555]">
                        <p class="font-semibold" id="modal-protected-text"></p>
                        <p class="mt-1 text-xs">Tidak ada tindakan yang tersedia.</p>
                    </div>
                </div>

                <button onclick="closeSeatModal()" class="mt-4 w-full rounded-[var(--radius-sm)] border border-[#e6e6e6] bg-white px-4 py-2 text-sm font-semibold text-[#555555] transition-colors hover:bg-[#faf9f8]">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const STATUS_LABELS = {
            AVAILABLE: 'Tersedia',
            HELD: 'Ditahan',
            SOLD: 'Terjual',
            BLOCKED: 'Rusak',
        };

        const STATUS_COLORS = {
            AVAILABLE: 'text-emerald-700',
            HELD: 'text-amber-700',
            SOLD: 'text-neutral-700',
            BLOCKED: 'text-red-700',
        };

        let pendingForm = null;

        function handleSeatClick(btn) {
            const seatId = btn.dataset.seat;
            const className = btn.dataset.class;
            const currentStatus = btn.dataset.status;
            const formId = btn.dataset.form;

            pendingForm = document.getElementById(formId);

            document.getElementById('modal-seat-code').textContent = seatId;
            document.getElementById('modal-seat-number').textContent = seatId;
            document.getElementById('modal-seat-class').textContent = className;

            const statusEl = document.getElementById('modal-seat-status');
            statusEl.textContent = STATUS_LABELS[currentStatus] || currentStatus;
            statusEl.className = 'font-bold ' + (STATUS_COLORS[currentStatus] || '');

            document.getElementById('modal-available-action').classList.toggle('hidden', currentStatus !== 'AVAILABLE');
            document.getElementById('modal-blocked-action').classList.toggle('hidden', currentStatus !== 'BLOCKED');
            document.getElementById('modal-protected-action').classList.toggle('hidden', !['HELD', 'SOLD'].includes(currentStatus));

            if (currentStatus === 'HELD') {
                document.getElementById('modal-protected-text').textContent = 'Kursi sedang dalam sesi checkout.';
            } else if (currentStatus === 'SOLD') {
                document.getElementById('modal-protected-text').textContent = 'Kursi sudah terjual.';
            }

            const modal = document.getElementById('seat-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeSeatModal() {
            const modal = document.getElementById('seat-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            pendingForm = null;
        }

        function confirmToggle() {
            if (!pendingForm) return;
            closeSeatModal();
            pendingForm.submit();
        }
    </script>
    @endpush
@endsection
