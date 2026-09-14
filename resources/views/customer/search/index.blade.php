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
            <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
                <p class="text-sm text-text-muted" x-text="filteredTrips.length + ' perjalanan ditemukan'">{{ count($trips) }} perjalanan ditemukan</p>
                <button type="button" class="btn-secondary btn-sm lg:hidden" @click="toggle()">
                    Filter & Urutkan
                </button>
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

                            <div>
                                <x-ui.select label="Urutkan" name="sort" id="sort" x-model="sortBy">
                                    <option value="departure">Waktu Keberangkatan</option>
                                    <option value="price">Harga Terendah</option>
                                    <option value="duration">Durasi Terpendek</option>
                                </x-ui.select>
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
                        <x-ui.empty-state
                            title="Tidak ada perjalanan ditemukan"
                            description="Coba ubah tanggal, rute, atau jenis layanan pencarian Anda."
                            :action="route('home')"
                            action-label="Cari Ulang"
                        />
                    </template>

                    <template x-for="trip in filteredTrips" :key="trip.id">
                        <article class="card overflow-hidden transition-shadow hover:shadow-md">
                            <div class="card-body">
                                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                                    <div class="flex-1">
                                        <div class="mb-2 flex flex-wrap items-center gap-2">
                                            <span class="badge-info" x-text="trip.service"></span>
                                            <span class="text-sm text-text-muted" x-text="trip.duration"></span>
                                        </div>

                                        <h3 class="text-xl font-bold text-text">
                                            <span x-text="trip.origin"></span>
                                            <span class="mx-2 text-brand" aria-hidden="true">→</span>
                                            <span x-text="trip.destination"></span>
                                        </h3>

                                        <div class="mt-3 flex flex-wrap gap-6 text-sm">
                                            <div>
                                                <span class="text-text-subtle">Berangkat</span>
                                                <p class="font-semibold text-text" x-text="trip.departure"></p>
                                            </div>
                                            <div>
                                                <span class="text-text-subtle">Tiba</span>
                                                <p class="font-semibold text-text" x-text="trip.arrival"></p>
                                            </div>
                                            <div>
                                                <span class="text-text-subtle">Kelas</span>
                                                <p class="font-semibold text-text" x-text="trip.class"></p>
                                            </div>
                                        </div>

                                        <div class="mt-3 flex flex-wrap gap-2">
                                            <template x-for="facility in trip.facilities" :key="facility">
                                                <span class="rounded-full bg-surface px-2.5 py-1 text-xs font-medium text-text-muted" x-text="facility"></span>
                                            </template>
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-start gap-3 border-t border-border pt-4 lg:min-w-[180px] lg:border-t-0 lg:border-l lg:pl-6 lg:pt-0">
                                        <div>
                                            <p class="text-sm text-text-subtle">Mulai dari</p>
                                            <p class="text-2xl font-bold text-text" x-text="'Rp ' + formatPrice(trip.price)"></p>
                                            <p class="text-xs text-text-muted" x-text="trip.seats_available + ' kursi tersedia'"></p>
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
                sortBy: 'departure',
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

                    if (this.sortBy === 'price') {
                        result.sort((a, b) => a.price - b.price);
                    } else if (this.sortBy === 'duration') {
                        result.sort((a, b) => a.duration.localeCompare(b.duration));
                    } else {
                        result.sort((a, b) => a.departure.localeCompare(b.departure));
                    }

                    return result;
                },

                toggle() {
                    this.open = !this.open;
                },

                resetFilters() {
                    this.selectedServices = [];
                    this.selectedClasses = [];
                    this.sortBy = 'departure';
                },

                formatPrice(price) {
                    return new Intl.NumberFormat('id-ID').format(price);
                }
            }
        }
    </script>
    @endpush
@endsection
