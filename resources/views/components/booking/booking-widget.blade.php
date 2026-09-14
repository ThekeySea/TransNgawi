@props(['action' => null, 'compact' => false])

@php
    $action = $action ?? route('search.index');
    $cities = \App\Support\MockData::cities();
    $services = \App\Support\MockData::serviceTypes();
@endphp

<div id="booking-widget" {{ $attributes->merge(['class' => 'relative z-[var(--z-booking)] w-full rounded-[var(--radius-xl)] border border-border bg-white shadow-[var(--shadow-widget)]']) }}>
    <div class="p-3.5 sm:p-5 md:p-7" x-data="{ selectedService: '{{ $services[0]['code'] ?? 'ANTIBU' }}' }">
        {{-- Header --}}
        <div class="mb-3 sm:mb-4">
            <h2 class="text-base font-bold tracking-tight text-text sm:text-lg md:text-xl">Pesan Tiket Cepat</h2>
        </div>

        {{-- Service Pills --}}
        <div class="mb-3 sm:mb-4 flex items-center gap-1.5">
            @foreach ($services as $service)
                <button
                    type="button"
                    @click="selectedService = '{{ $service['code'] }}'"
                    :class="selectedService === '{{ $service['code'] }}' ? 'bg-[#ff750f] text-white font-bold shadow-sm' : 'bg-neutral-100 text-text-muted hover:bg-neutral-200 border border-border font-semibold'"
                    class="rounded-full px-2.5 py-1 text-[10px] sm:px-3 sm:py-1.5 sm:text-xs"
                >
                    {{ $service['name'] }}
                </button>
            @endforeach
        </div>

        <form action="{{ $action }}" method="GET">
            <input type="hidden" name="service" x-model="selectedService">

            {{-- Row 1: Dari & Ke --}}
            <div class="grid grid-cols-2 gap-2.5 sm:gap-3">
                <div>
                    <x-ui.select label="Dari" name="origin" id="origin">
                        <option value="">Asal</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city }}" @selected($city === 'Surabaya')>{{ $city }}</option>
                        @endforeach
                    </x-ui.select>
                </div>

                <div>
                    <x-ui.select label="Ke" name="destination" id="destination">
                        <option value="">Tujuan</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city }}" @selected($city === 'Jakarta')>{{ $city }}</option>
                        @endforeach
                    </x-ui.select>
                </div>
            </div>

            {{-- Row 2: Tanggal & Penumpang --}}
            <div class="mt-2.5 grid grid-cols-2 gap-2.5 sm:mt-3 sm:gap-3">
                <div>
                    <x-ui.input label="Tanggal" type="date" name="date" id="date" value="{{ date('Y-m-d', strtotime('+2 days')) }}" />
                </div>

                <div x-data="passengerStepper(1, 1, 4)">
                    <label for="passengers" class="input-label">Penumpang</label>
                    <div class="flex items-center gap-1.5 sm:gap-2">
                        <button type="button" class="btn-secondary h-10 w-10 shrink-0 rounded-lg text-base font-bold sm:h-11 sm:w-11 sm:text-lg" @click="decrement()" aria-label="Kurangi penumpang">−</button>
                        <input type="number" name="passengers" id="passengers" x-model="count" min="1" max="4" class="input h-10 flex-1 text-center text-sm font-semibold sm:h-11" readonly />
                        <button type="button" class="btn-secondary h-10 w-10 shrink-0 rounded-lg text-base font-bold sm:h-11 sm:w-11 sm:text-lg" @click="increment()" aria-label="Tambah penumpang">+</button>
                    </div>
                </div>
            </div>

            {{-- Row 3: CTA --}}
            <div class="mt-3 sm:mt-4">
                <x-ui.button type="submit" size="lg" class="h-10 w-full text-sm font-bold shadow-md sm:h-11 sm:text-base md:h-12">Cari Perjalanan</x-ui.button>
            </div>
        </form>
    </div>
</div>
