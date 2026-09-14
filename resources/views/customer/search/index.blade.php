@extends('layouts.customer')

@section('title', 'Hasil Pencarian')

@section('content')
    {{-- Hero --}}
    <section class="relative -mt-16 overflow-hidden bg-[#0a0a0a] py-20 lg:-mt-20 lg:py-28">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-br from-[#ff750f]/20 via-transparent to-transparent"></div>
        </div>
        <div class="container-app relative z-10">
            <div class="max-w-3xl">
                <h1 class="text-3xl font-extrabold leading-tight tracking-tight text-white sm:text-4xl lg:text-5xl">
                    Cari Perjalanan
                </h1>
                <p class="mt-4 max-w-xl text-sm leading-relaxed text-neutral-400 sm:text-base">
                    Temukan bus terbaik untuk perjalananmu. Pilih rute, kelas, dan jadwal yang sesuai kebutuhan.
                </p>
            </div>
        </div>
    </section>

    {{-- Search Results --}}
    <section class="section-spacing bg-surface" x-data="searchFilters()">
        <div class="container-app">
            {{-- Active Filters Summary --}}
            @if (!empty($filters['origin']) || !empty($filters['destination']) || !empty($filters['date']) || !empty($filters['date_preset']))
                <div class="mb-4 flex flex-wrap items-center gap-2 text-sm">
                    <span class="text-text-muted">Filter:</span>
                    @if (!empty($filters['origin']))
                        <span class="inline-flex items-center gap-1 rounded-full bg-[#ff750f]/10 px-3 py-1 text-xs font-semibold text-[#ff750f]">
                            Dari: {{ $filters['origin'] }}
                        </span>
                    @endif
                    @if (!empty($filters['destination']))
                        <span class="inline-flex items-center gap-1 rounded-full bg-[#ff750f]/10 px-3 py-1 text-xs font-semibold text-[#ff750f]">
                            Ke: {{ $filters['destination'] }}
                        </span>
                    @endif
                    @if (!empty($filters['date_preset']))
                        <span class="inline-flex items-center gap-1 rounded-full bg-[#ff750f]/10 px-3 py-1 text-xs font-semibold text-[#ff750f]">
                            {{ match($filters['date_preset']) { '7_days' => '7 Hari ke Depan', '14_days' => '14 Hari ke Depan', '30_days' => '30 Hari ke Depan', default => $filters['date_preset'] } }}
                        </span>
                    @elseif (!empty($filters['date']))
                        <span class="inline-flex items-center gap-1 rounded-full bg-[#ff750f]/10 px-3 py-1 text-xs font-semibold text-[#ff750f]">
                            {{ \Carbon\Carbon::parse($filters['date'])->format('d M Y') }}
                        </span>
                    @endif
                    <a href="{{ route('perjalanan.index') }}" class="text-xs text-text-muted underline hover:text-[#ff750f]">Hapus semua</a>
                </div>
            @endif

            {{-- Date Preset Chips --}}
            <div class="mb-6 flex flex-wrap items-center gap-2">
                <span class="text-xs font-semibold text-text-muted">Rentang:</span>
                @php
                    $currentPreset = $filters['date_preset'] ?? null;
                    $currentDate = $filters['date'] ?? null;
                @endphp
                <a href="{{ route('perjalanan.index', array_merge($filters, ['date_preset' => null, 'date' => null])) }}"
                   class="rounded-full px-3 py-1.5 text-xs font-semibold transition-colors {{ !$currentPreset && !$currentDate ? 'bg-[#ff750f] text-white' : 'bg-neutral-100 text-text-muted hover:bg-neutral-200' }}">
                    Semua
                </a>
                <a href="{{ route('perjalanan.index', array_merge($filters, ['date_preset' => '7_days', 'date' => null])) }}"
                   class="rounded-full px-3 py-1.5 text-xs font-semibold transition-colors {{ $currentPreset === '7_days' ? 'bg-[#ff750f] text-white' : 'bg-neutral-100 text-text-muted hover:bg-neutral-200' }}">
                    7 Hari ke Depan
                </a>
                <a href="{{ route('perjalanan.index', array_merge($filters, ['date_preset' => '14_days', 'date' => null])) }}"
                   class="rounded-full px-3 py-1.5 text-xs font-semibold transition-colors {{ $currentPreset === '14_days' ? 'bg-[#ff750f] text-white' : 'bg-neutral-100 text-text-muted hover:bg-neutral-200' }}">
                    14 Hari ke Depan
                </a>
                <a href="{{ route('perjalanan.index', array_merge($filters, ['date_preset' => '30_days', 'date' => null])) }}"
                   class="rounded-full px-3 py-1.5 text-xs font-semibold transition-colors {{ $currentPreset === '30_days' ? 'bg-[#ff750f] text-white' : 'bg-neutral-100 text-text-muted hover:bg-neutral-200' }}">
                    30 Hari ke Depan
                </a>
                <form action="{{ route('perjalanan.index') }}" method="GET" class="inline-flex items-center gap-1.5">
                    @foreach ($filters as $key => $val)
                        @if ($key !== 'date' && $key !== 'date_preset' && $val)
                            <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                        @endif
                    @endforeach
                    <input type="date" name="date" value="{{ $currentDate ?? '' }}"
                           class="rounded-full border border-[#e6e6e6] bg-white px-3 py-1.5 text-xs font-semibold text-text-muted focus:border-[#ff750f] focus:outline-none"
                           onchange="this.form.submit()">
                </form>
            </div>

            <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
                <p class="text-sm text-text-muted" x-text="filteredTrips.length + ' perjalanan ditemukan'">{{ count($trips) }} perjalanan ditemukan</p>
                <div class="flex items-center gap-3">
                    {{-- Sort Dropdown (Server-side) --}}
                    <form action="{{ route('perjalanan.index') }}" method="GET" class="inline-flex items-center gap-2">
                        @foreach ($filters as $key => $val)
                            @if ($key !== 'sort' && $val)
                                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                            @endif
                        @endforeach
                        <label for="sort-desktop" class="text-xs text-text-muted hidden sm:inline">Urutkan:</label>
                        <select name="sort" id="sort-desktop" onchange="this.form.submit()"
                                class="rounded-lg border border-[#e6e6e6] bg-white px-3 py-1.5 text-xs font-semibold text-text focus:border-[#ff750f] focus:outline-none">
                            <option value="departure_earliest" @selected(($filters['sort'] ?? 'departure_earliest') === 'departure_earliest')>Waktu Terpagi</option>
                            <option value="departure_latest" @selected(($filters['sort'] ?? '') === 'departure_latest')>Waktu Terakhir</option>
                            <option value="price_lowest" @selected(($filters['sort'] ?? '') === 'price_lowest')>Harga Terendah</option>
                            <option value="price_highest" @selected(($filters['sort'] ?? '') === 'price_highest')>Harga Tertinggi</option>
                        </select>
                    </form>
                    <button type="button" class="btn-secondary btn-sm lg:hidden" @click="toggle()">
                        Filter
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">
                <aside :class="open ? 'block' : 'hidden lg:block'" class="lg:col-span-1">
                    <div class="card sticky top-24">
                        <div class="card-body space-y-5">
                            <h3 class="font-bold text-text">Filter</h3>

                            <div>
                                <p class="input-label">Jenis Layanan</p>
                                <div class="space-y-2">
                                    @foreach ($availableServices as $service)
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input
                                                type="checkbox"
                                                value="{{ $service['code'] }}"
                                                x-model="selectedServices"
                                                class="h-4 w-4 rounded border-[#e6e6e6] text-[#ff750f] focus:ring-[#ff750f]/20"
                                                style="accent-color: #ff750f"
                                            >
                                            <span class="text-sm text-text">{{ $service['name'] }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <p class="input-label">Kelas</p>
                                <div class="space-y-2">
                                    @foreach ($availableClasses as $class)
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input
                                                type="checkbox"
                                                value="{{ $class['code'] }}"
                                                x-model="selectedClasses"
                                                class="h-4 w-4 rounded border-[#e6e6e6] text-[#ff750f] focus:ring-[#ff750f]/20"
                                                style="accent-color: #ff750f"
                                            >
                                            <span class="text-sm text-text">{{ $class['name'] }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <button
                                type="button"
                                class="btn-secondary w-full text-sm"
                                @click="resetFilters()"
                            >
                                Reset Filter
                            </button>
                        </div>
                    </div>
                </aside>

                <div class="space-y-4 lg:col-span-3">
                    <template x-if="filteredTrips.length === 0">
                        <div class="py-16 text-center">
                            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-neutral-100">
                                <svg class="h-8 w-8 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-text">Tidak ada perjalanan ditemukan</h3>
                            <p class="mt-2 text-sm text-text-muted">Tidak ada perjalanan pada rentang waktu ini. Coba ubah tanggal atau filter pencarian Anda.</p>
                            <a href="{{ route('home') }}" class="btn-primary mt-6 inline-block">Cari Ulang</a>
                        </div>
                    </template>

                    <template x-for="trip in filteredTrips" :key="trip.id">
                        <article class="card overflow-hidden transition-shadow hover:shadow-md">
                            <div class="card-body">
                                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                                    <div class="flex-1">
                                        <div class="mb-2 flex flex-wrap items-center gap-2">
                                            <span class="badge-info" x-text="trip.service"></span>
                                            <span class="text-xs text-text-muted" x-text="trip.bus_model"></span>
                                            <span class="text-sm text-text-muted" x-text="trip.duration"></span>
                                        </div>

                                        <h3 class="text-xl font-bold text-text">
                                            <span x-text="trip.origin"></span>
                                            <span class="mx-2 text-brand" aria-hidden="true">→</span>
                                            <span x-text="trip.destination"></span>
                                        </h3>

                                        <div class="mt-3 flex flex-wrap gap-6 text-sm">
                                            <div>
                                                <span class="text-text-subtle">Waktu Berangkat</span>
                                                <p class="font-semibold text-text" x-text="trip.departure_full"></p>
                                            </div>
                                            <div>
                                                <span class="text-text-subtle">Estimasi Tiba</span>
                                                <p class="font-semibold text-text" x-text="trip.arrival_full"></p>
                                            </div>
                                        </div>

                                        <div class="mt-3 flex flex-wrap gap-2">
                                            <template x-for="facility in trip.facilities" :key="facility">
                                                <span class="rounded-full bg-surface px-2.5 py-1 text-xs font-medium text-text-muted" x-text="facility"></span>
                                            </template>
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-start gap-3 border-t border-border pt-4 lg:min-w-[200px] lg:border-t-0 lg:border-l lg:pl-6 lg:pt-0">
                                        <div>
                                            <p class="text-sm text-text-subtle">Mulai dari</p>
                                            <p class="text-2xl font-bold text-text" x-text="'Rp ' + formatPrice(trip.price)"></p>
                                            <p class="text-xs text-text-muted">
                                                <span x-text="'Sisa ' + trip.seats_available + ' Kursi'"></span>
                                            </p>
                                        </div>
                                        <a :href="'/trips/' + trip.id" class="btn-primary w-full lg:w-auto text-center">Pilih</a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </template>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        function searchFilters() {
            return {
                open: false,
                selectedServices: @js(($filters['service'] ?? null) ? [$filters['service']] : []),
                selectedClasses: @js(($filters['class'] ?? null) ? [$filters['class']] : []),
                allTrips: @js($trips),

                get filteredTrips() {
                    let result = [...this.allTrips];

                    if (this.selectedServices.length > 0) {
                        result = result.filter(t => this.selectedServices.includes(t.service_lower));
                    }

                    if (this.selectedClasses.length > 0) {
                        result = result.filter(t => this.selectedClasses.includes(t.class_lower));
                    }

                    return result;
                },

                toggle() {
                    this.open = !this.open;
                },

                resetFilters() {
                    this.selectedServices = [];
                    this.selectedClasses = [];
                },

                formatPrice(price) {
                    return new Intl.NumberFormat('id-ID').format(price);
                }
            }
        }
    </script>
    @endpush
@endsection
