@extends('layouts.customer')

@section('title', $trip->route->origin->name . ' → ' . $trip->route->destination->name)

@section('content')
    {{-- Hero --}}
    <section class="relative -mt-16 overflow-hidden bg-[#0a0a0a] py-16 lg:-mt-20 lg:py-20">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-br from-[#ff750f]/20 via-transparent to-transparent"></div>
        </div>
        <div class="container-app relative z-10">
            <div class="max-w-3xl">
                <div class="mb-3 flex flex-wrap items-center gap-2">
                    <span class="badge-info">{{ $trip->route->service_category->label() }}</span>
                    <span class="text-xs text-neutral-400">{{ $trip->bus->plate_number }}</span>
                </div>
                <h1 class="text-2xl font-extrabold leading-tight tracking-tight text-white sm:text-3xl lg:text-4xl">
                    {{ $trip->route->origin->name }}
                    <span class="mx-2 text-[#ff750f]" aria-hidden="true">→</span>
                    {{ $trip->route->destination->name }}
                </h1>
                <p class="mt-3 text-sm text-neutral-400">
                    {{ $trip->departs_at->format('d M Y') }} · {{ $duration }}
                </p>
            </div>
        </div>
    </section>

    {{-- Main Content: 2-column split --}}
    <section class="section-spacing bg-surface">
        <div class="container-app">
            <form action="{{ route('booking.seats.store', $trip) }}" method="POST" id="booking-form">
                @csrf
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-5">

                    {{-- Left Column: Seat Selection (lg:col-span-3) --}}
                    <div class="space-y-5 lg:col-span-3" x-data="{
                        selectedClass: '',
                        selectedPrice: 0,
                        countdown: 0,
                        timerActive: false,
                        init() {
                            this.$watch('selected', () => {
                                this.updateTimer();
                            });
                        },
                        updateTimer() {
                            if (this.selected.length > 0 && !this.timerActive) {
                                this.timerActive = true;
                                this.countdown = 900;
                                this.interval = setInterval(() => {
                                    if (this.countdown > 0) {
                                        this.countdown--;
                                    } else {
                                        clearInterval(this.interval);
                                        this.timerActive = false;
                                    }
                                }, 1000);
                            } else if (this.selected.length === 0) {
                                this.timerActive = false;
                                this.countdown = 0;
                                clearInterval(this.interval);
                            }
                        },
                        formatTime(s) {
                            const m = Math.floor(s / 60);
                            const sec = s % 60;
                            return m.toString().padStart(2, '0') + ':' + sec.toString().padStart(2, '0');
                        }
                    }">

                        {{-- Price Filter Chips --}}
                        <div class="card">
                            <div class="card-body">
                                <h3 class="mb-3 text-sm font-bold text-text">Filter Berdasarkan Harga</h3>
                                <div class="flex flex-wrap gap-2">
                                    <button type="button"
                                        @click="selectedClass = ''; selectedPrice = 0"
                                        :class="selectedPrice === 0 ? 'bg-[#ff750f] text-white border-[#ff750f]' : 'bg-white text-[#555555] border-[#e6e6e6]'"
                                        class="rounded-full border px-3 py-1.5 text-xs font-semibold transition-all hover:scale-105">
                                        Semua
                                    </button>
                                    @foreach ($fares as $fare)
                                        <button type="button"
                                            @click="selectedClass = '{{ $fare['class'] }}'; selectedPrice = {{ $fare['price'] }}"
                                            :class="selectedPrice === {{ $fare['price'] }} ? 'bg-[#ff750f] text-white border-[#ff750f]' : 'bg-white text-[#555555] border-[#e6e6e6]'"
                                            class="rounded-full border px-3 py-1.5 text-xs font-semibold transition-all hover:scale-105">
                                            {{ $fare['class'] }} · Rp {{ number_format($fare['price'], 0, ',', '.') }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Seat Map --}}
                        <div class="card">
                            <div class="card-body">
                                <h2 class="mb-4 text-base font-bold text-text">Pilih Kursi</h2>
                                <div x-data="seatMap({{ 4 }}, @js($occupied))" x-effect="selected = $data.selected">
                                    <div class="mx-auto max-w-sm">
                                        <p class="mb-3 text-center text-xs font-semibold uppercase tracking-wide text-text-subtle">Depan Bus</p>
                                        <div class="mb-3 flex justify-center">
                                            <div class="flex h-7 w-7 items-center justify-center rounded-full bg-neutral-100 text-xs text-text-subtle">🚌</div>
                                        </div>

                                        @php
                                            $rows = collect($seats)->groupBy(fn ($s) => $s['id'][0]);
                                            $colCount = $busModel === 'ANTIBU_SATSET' ? 3 : 4;
                                            $classSymbols = ['Sukian' => '◻', 'SukianPlus' => '◈', 'SukianPro' => '◆'];
                                            $classColors = [
                                                'Sukian' => 'bg-emerald-50 border-emerald-300 text-emerald-700',
                                                'SukianPlus' => 'bg-blue-50 border-blue-300 text-blue-700',
                                                'SukianPro' => 'bg-purple-50 border-purple-300 text-purple-700',
                                            ];
                                            $seatLookup = collect($seats)->keyBy('id');
                                        @endphp

                                        <div class="space-y-1.5">
                                            @foreach ($rows as $rowLabel => $rowSeats)
                                                <div class="flex items-center justify-center gap-1.5">
                                                    <span class="w-5 text-center text-[10px] font-bold text-text-subtle">{{ $rowLabel }}</span>
                                                    @if ($busModel === 'ANTIBU_SATSET')
                                                        @for ($col = 1; $col <= $colCount; $col++)
                                                            @php
                                                                $seatId = $rowLabel . $col;
                                                                $seatData = $seatLookup->get($seatId);
                                                                $isOccupied = in_array($seatId, $occupied);
                                                                $className = $seatData['class'] ?? 'Sukian';
                                                            @endphp
                                                            @if ($col === 2)
                                                                <div class="w-3"></div>
                                                            @endif
                                                            <button
                                                                type="button"
                                                                @click="toggle('{{ $seatId }}')"
                                                                :disabled="isOccupied('{{ $seatId }}')"
                                                                :class="{
                                                                    'bg-[#ff750f] text-white border-[#ff750f]': isSelected('{{ $seatId }}'),
                                                                    'bg-neutral-200 text-neutral-500 cursor-not-allowed opacity-60': isOccupied('{{ $seatId }}'),
                                                                    '{{ $classColors[$className] }}': !isSelected('{{ $seatId }}') && !isOccupied('{{ $seatId }}')
                                                                }"
                                                                class="flex h-8 w-8 items-center justify-center rounded border text-[9px] font-semibold transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-[#ff750f] hover:scale-105 disabled:hover:scale-100"
                                                                aria-label="Kursi {{ $seatId }}{{ $isOccupied ? ' (terisi)' : '' }}"
                                                                title="{{ $className }}">
                                                                {{ $seatId }}
                                                            </button>
                                                        @endfor
                                                    @else
                                                        @for ($col = 1; $col <= $colCount; $col++)
                                                            @php
                                                                $seatId = $rowLabel . $col;
                                                                $seatData = $seatLookup->get($seatId);
                                                                $isOccupied = in_array($seatId, $occupied);
                                                                $className = $seatData['class'] ?? 'Sukian';
                                                            @endphp
                                                            @if ($col === 3)
                                                                <div class="w-3"></div>
                                                            @endif
                                                            <button
                                                                type="button"
                                                                @click="toggle('{{ $seatId }}')"
                                                                :disabled="isOccupied('{{ $seatId }}')"
                                                                :class="{
                                                                    'bg-[#ff750f] text-white border-[#ff750f]': isSelected('{{ $seatId }}'),
                                                                    'bg-neutral-200 text-neutral-500 cursor-not-allowed opacity-60': isOccupied('{{ $seatId }}'),
                                                                    '{{ $classColors[$className] }}': !isSelected('{{ $seatId }}') && !isOccupied('{{ $seatId }}')
                                                                }"
                                                                class="flex h-8 w-8 items-center justify-center rounded border text-[9px] font-semibold transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-[#ff750f] hover:scale-105 disabled:hover:scale-100"
                                                                aria-label="Kursi {{ $seatId }}{{ $isOccupied ? ' (terisi)' : '' }}"
                                                                title="{{ $className }}">
                                                                {{ $seatId }}
                                                            </button>
                                                        @endfor
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <p class="mt-3 text-center text-xs text-text-muted">
                                        <span x-text="selected.length"></span> dari 4 kursi dipilih
                                    </p>

                                    <template x-for="seatId in selected" :key="seatId">
                                        <input type="hidden" name="seats[]" :value="seatId">
                                    </template>
                                </div>
                            </div>
                        </div>

                        {{-- Seat Legend --}}
                        <div class="card">
                            <div class="card-body">
                                <h3 class="mb-3 text-sm font-bold text-text">Kenali Tipe Kursi Anda</h3>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-xs">
                                        <thead>
                                            <tr class="border-b border-border text-left text-text-subtle">
                                                <th class="pb-2 pr-4 font-semibold">Tipe Kursi</th>
                                                <th class="pb-2 pr-4 font-semibold">Ikon</th>
                                                <th class="pb-2 font-semibold">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-border">
                                            @foreach (['Sukian' => '◻', 'SukianPlus' => '◈', 'SukianPro' => '◆'] as $cls => $icon)
                                                <tr>
                                                    <td class="py-2 pr-4 font-semibold text-text">{{ $cls }}</td>
                                                    <td class="py-2 pr-4">
                                                        <span class="inline-flex h-5 w-5 items-center justify-center rounded border
                                                            @if($cls === 'Sukian') border-emerald-300 bg-emerald-50 text-emerald-700
                                                            @elseif($cls === 'SukianPlus') border-blue-300 bg-blue-50 text-blue-700
                                                            @else border-purple-300 bg-purple-50 text-purple-700 @endif
                                                            text-[9px]">{{ $icon }}</span>
                                                    </td>
                                                    <td class="py-2 text-text-muted">
                                                        @if($cls === 'Sukian') Rp 189.000
                                                        @elseif($cls === 'SukianPlus') Rp 210.000
                                                        @else Rp 250.000 @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3 flex flex-wrap gap-3 text-[10px]">
                                    <span class="flex items-center gap-1.5"><span class="h-3 w-3 rounded bg-emerald-500"></span> Tersedia</span>
                                    <span class="flex items-center gap-1.5"><span class="h-3 w-3 rounded bg-[#ff750f]"></span> Dipilih</span>
                                    <span class="flex items-center gap-1.5"><span class="h-3 w-3 rounded bg-neutral-300"></span> Terjual</span>
                                </div>
                            </div>
                        </div>

                        {{-- Countdown Timer --}}
                        <div x-show="timerActive" x-transition class="card border-[#ff750f]/30 bg-[#ff750f]/5">
                            <div class="card-body flex flex-row items-center gap-4">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#ff750f] text-sm font-bold text-white">
                                    <span x-text="formatTime(countdown)"></span>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-text">Waktu Pemesanan</p>
                                    <p class="text-xs text-text-muted">Pilih kursi dan lanjutkan ke checkout dalam waktu yang tersisa.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column: Bus Info (lg:col-span-2) --}}
                    <div class="space-y-5 lg:col-span-2" x-data="{ activeTab: 'info', galleryTab: 'exterior' }">

                        {{-- Bus Header --}}
                        <div class="card">
                            <div class="card-body">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h2 class="text-lg font-bold text-text">{{ $trip->bus->plate_number }}</h2>
                                        <p class="text-sm text-text-muted">{{ $trip->bus->model_type->label() }}</p>
                                    </div>
                                    <span class="badge-info text-[10px]">{{ $trip->route->service_category->label() }}</span>
                                </div>
                                <div class="mt-4 grid grid-cols-2 gap-3">
                                    <div class="rounded-[var(--radius-sm)] bg-[#faf9f8] p-3">
                                        <p class="text-[10px] font-semibold text-text-subtle">Berangkat</p>
                                        <p class="text-base font-bold text-text">{{ $trip->departs_at->format('H:i') }}</p>
                                        <p class="text-[10px] text-text-muted">{{ $trip->route->origin->name }}</p>
                                    </div>
                                    <div class="rounded-[var(--radius-sm)] bg-[#faf9f8] p-3">
                                        <p class="text-[10px] font-semibold text-text-subtle">Tiba</p>
                                        <p class="text-base font-bold text-text">{{ $trip->arrives_at->format('H:i') }}</p>
                                        <p class="text-[10px] text-text-muted">{{ $trip->route->destination->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Photo Gallery Tabs --}}
                        <div class="card">
                            <div class="card-body">
                                <div class="flex gap-1 border-b border-border pb-2">
                                    @foreach (['exterior' => 'Eksterior Bus', 'interior' => 'Tampilan Kursi', 'facility' => 'Fasilitas'] as $tab => $label)
                                        <button type="button"
                                            @click="galleryTab = '{{ $tab }}'"
                                            :class="galleryTab === '{{ $tab }}' ? 'text-[#ff750f] border-b-2 border-[#ff750f]' : 'text-text-muted border-b-2 border-transparent hover:text-text'"
                                            class="px-2 py-1 text-xs font-semibold transition-all">
                                            {{ $label }}
                                        </button>
                                    @endforeach
                                </div>
                                <div class="mt-3 grid grid-cols-3 gap-2">
                                    @foreach ($trip->exterior_photos ?? [] as $i => $photo)
                                        <div x-show="galleryTab === 'exterior'" class="aspect-video overflow-hidden rounded-[var(--radius-sm)] bg-neutral-100">
                                            <img src="{{ $photo }}" alt="Eksterior {{ $i+1 }}" class="h-full w-full object-cover" loading="lazy">
                                        </div>
                                    @endforeach
                                    @if (empty($trip->exterior_photos))
                                        <div x-show="galleryTab === 'exterior'" class="col-span-3 flex h-24 items-center justify-center rounded-[var(--radius-sm)] bg-neutral-100 text-xs text-text-muted">
                                            Belum ada foto eksterior
                                        </div>
                                    @endif

                                    @foreach ($trip->interior_photos ?? [] as $i => $photo)
                                        <div x-show="galleryTab === 'interior'" class="aspect-video overflow-hidden rounded-[var(--radius-sm)] bg-neutral-100">
                                            <img src="{{ $photo }}" alt="Interior {{ $i+1 }}" class="h-full w-full object-cover" loading="lazy">
                                        </div>
                                    @endforeach
                                    @if (empty($trip->interior_photos))
                                        <div x-show="galleryTab === 'interior'" class="col-span-3 flex h-24 items-center justify-center rounded-[var(--radius-sm)] bg-neutral-100 text-xs text-text-muted">
                                            Belum ada foto interior
                                        </div>
                                    @endif

                                    @foreach ($trip->facility_photos ?? [] as $i => $photo)
                                        <div x-show="galleryTab === 'facility'" class="aspect-video overflow-hidden rounded-[var(--radius-sm)] bg-neutral-100">
                                            <img src="{{ $photo }}" alt="Fasilitas {{ $i+1 }}" class="h-full w-full object-cover" loading="lazy">
                                        </div>
                                    @endforeach
                                    @if (empty($trip->facility_photos))
                                        <div x-show="galleryTab === 'facility'" class="col-span-3 flex h-24 items-center justify-center rounded-[var(--radius-sm)] bg-neutral-100 text-xs text-text-muted">
                                            Belum ada foto fasilitas
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Facility Badges --}}
                        @if (!empty($trip->amenities))
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="mb-3 text-sm font-bold text-text">Fasilitas</h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($trip->amenities as $amenity)
                                            <span class="inline-flex items-center gap-1 rounded-full bg-[#faf9f8] border border-border px-2.5 py-1 text-[10px] font-semibold text-text">
                                                @if($amenity === 'WiFi')
                                                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.858 15.355-5.858 21.213 0"/></svg>
                                                @elseif($amenity === 'Toilet')
                                                    🚻
                                                @elseif($amenity === 'USB')
                                                    🔌
                                                @elseif($amenity === 'Selimut')
                                                    🧣
                                                @elseif($amenity === 'Cemilan')
                                                    🍿
                                                @elseif($amenity === 'Bantal')
                                                    🛏️
                                                @elseif($amenity === 'Makanan')
                                                    🍱
                                                @endif
                                                {{ $amenity }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Info Tabs --}}
                        <div class="card">
                            <div class="card-body">
                                <div class="flex gap-1 border-b border-border pb-2 overflow-x-auto">
                                    @foreach (['info' => 'Tentang', 'pickup' => 'Titik Naik', 'dropoff' => 'Titik Turun', 'rest' => 'Titik Istirahat', 'policy' => 'Kebijakan'] as $tab => $label)
                                        <button type="button"
                                            @click="activeTab = '{{ $tab }}'"
                                            :class="activeTab === '{{ $tab }}' ? 'text-[#ff750f] border-b-2 border-[#ff750f]' : 'text-text-muted border-b-2 border-transparent hover:text-text'"
                                            class="whitespace-nowrap px-2 py-1 text-xs font-semibold transition-all">
                                            {{ $label }}
                                        </button>
                                    @endforeach
                                </div>

                                <div class="mt-4 text-sm text-text-muted">
                                    {{-- Tentang --}}
                                    <div x-show="activeTab === 'info'">
                                        <p>Bus ini melayani rute <strong class="text-text">{{ $trip->route->origin->name }} → {{ $trip->route->destination->name }}</strong> dengan layanan <strong class="text-text">{{ $trip->route->service_category->label() }}</strong>.</p>
                                        <p class="mt-2">Durasi perjalanan sekitar <strong class="text-text">{{ $duration }}</strong>.</p>
                                        @if (!empty($trip->amenities))
                                            <p class="mt-2">Fasilitas yang tersedia: {{ implode(', ', $trip->amenities) }}.</p>
                                        @endif
                                    </div>

                                    {{-- Titik Naik --}}
                                    <div x-show="activeTab === 'pickup'">
                                        <div class="rounded-[var(--radius-sm)] bg-[#faf9f8] p-3">
                                            <p class="font-bold text-text">{{ $trip->route->origin->name }}</p>
                                            @if ($trip->origin_address)
                                                <p class="mt-1 text-xs">{{ $trip->origin_address }}</p>
                                            @else
                                                <p class="mt-1 text-xs">{{ $trip->route->origin->city ?? $trip->route->origin->name }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Titik Turun --}}
                                    <div x-show="activeTab === 'dropoff'">
                                        <div class="rounded-[var(--radius-sm)] bg-[#faf9f8] p-3">
                                            <p class="font-bold text-text">{{ $trip->route->destination->name }}</p>
                                            @if ($trip->destination_address)
                                                <p class="mt-1 text-xs">{{ $trip->destination_address }}</p>
                                            @else
                                                <p class="mt-1 text-xs">{{ $trip->route->destination->city ?? $trip->route->destination->name }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Titik Istirahat --}}
                                    <div x-show="activeTab === 'rest'">
                                        @if ($trip->rest_stop_name)
                                            <div class="rounded-[var(--radius-sm)] bg-[#faf9f8] p-3">
                                                <div class="flex items-center gap-2">
                                                    <p class="font-bold text-text">{{ $trip->rest_stop_name }}</p>
                                                    <span class="rounded-full bg-amber-100 px-2 py-0.5 text-[9px] font-semibold text-amber-700">ISTIRAHAT SAJA</span>
                                                </div>
                                                @if ($trip->rest_stop_address)
                                                    <p class="mt-1 text-xs">{{ $trip->rest_stop_address }}</p>
                                                @endif
                                                <p class="mt-2 text-[10px] text-amber-600">⚠ Titik ini hanya untuk istirahat. Tidak ada naik/turun penumpang.</p>
                                            </div>
                                        @else
                                            <p class="text-xs text-text-muted">Tidak ada titik istirahat pada perjalanan ini.</p>
                                        @endif
                                    </div>

                                    {{-- Kebijakan --}}
                                    <div x-show="activeTab === 'policy'">
                                        @if ($trip->policy)
                                            <div class="whitespace-pre-line text-xs leading-relaxed">{{ $trip->policy }}</div>
                                        @else
                                            <p class="text-xs text-text-muted">Kebijakan perjalanan belum tersedia.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Summary & CTA --}}
                        <div class="card sticky top-24 border-[#ff750f]/20">
                            <div class="card-body">
                                <h3 class="text-base font-bold text-text">Ringkasan</h3>
                                <dl class="mt-3 space-y-2 text-xs">
                                    <div class="flex justify-between">
                                        <dt class="text-text-muted">Rute</dt>
                                        <dd class="font-semibold text-text">{{ $trip->route->origin->name }} → {{ $trip->route->destination->name }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-text-muted">Tanggal</dt>
                                        <dd class="font-semibold text-text">{{ $trip->departs_at->format('d M Y') }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-text-muted">Waktu</dt>
                                        <dd class="font-semibold text-text">{{ $trip->departs_at->format('H:i') }} – {{ $trip->arrives_at->format('H:i') }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-text-muted">Layanan</dt>
                                        <dd class="font-semibold text-text">{{ $trip->route->service_category->label() }}</dd>
                                    </div>
                                </dl>

                                <div class="mt-3 border-t border-border pt-3">
                                    <p class="text-[10px] text-text-muted">Harga mulai dari</p>
                                    <p class="text-lg font-bold text-[#ff750f]">Rp {{ number_format($fares->min('price'), 0, ',', '.') }}</p>
                                </div>

                                <button type="submit" class="btn-primary mt-3 w-full" id="book-btn" disabled>
                                    Pilih Kursi
                                </button>

                                @error('seats')
                                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('booking-form');
            const btn = document.getElementById('book-btn');
            if (!form || !btn) return;

            const check = () => {
                btn.disabled = form.querySelectorAll('input[name="seats[]"]').length === 0;
            };

            new MutationObserver(check).observe(form, { childList: true, subtree: true });
            check();
        });
    </script>
    @endpush
@endsection
