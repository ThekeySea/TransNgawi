@extends('layouts.admin')

@section('title', 'Buat Trip')

@section('content')
    <div class="container-app max-w-2xl">
        <h1 class="text-3xl font-bold tracking-tight">Buat Trip</h1>
        <p class="mt-2 text-base text-[#555555]">Langkah {{ $step }} dari 4.</p>

        @php
            $steps = [1 => 'Layanan', 2 => 'Rute', 3 => 'Jadwal & Bus', 4 => 'Harga', 5 => 'Detail Trip'];
        @endphp
        <ol class="mt-6 flex flex-wrap gap-2 text-xs font-semibold" aria-label="Langkah pembuatan trip">
            @foreach ($steps as $number => $label)
                <li class="rounded-full px-3 py-1.5 @if($number === $step) bg-[#ff750f] text-white @elseif($number < $step) bg-[#ff750f]/15 text-[#ff750f] @else bg-[#e6e6e6] text-[#555555] @endif">
                    {{ $number }}. {{ $label }}
                </li>
            @endforeach
        </ol>

        <div class="card mt-6 p-6 md:p-8">
            @if ($step === 1)
                <form method="POST" action="{{ route('admin.trips.store-step-1') }}">
                    @csrf
                    <p class="input-label">Pilih layanan</p>
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3" x-data="{ picked: @js(old('service_category', $wizard['service_category'] ?? '')) }">
                        @foreach ($services as $service)
                            <label class="cursor-pointer rounded-[var(--radius-sm)] border p-4 transition-all" :class="picked === '{{ $service->value }}' ? 'border-[#ff750f] bg-[#ff750f]/5' : 'border-[#e6e6e6]'">
                                <input type="radio" name="service_category" value="{{ $service->value }}" x-model="picked" class="h-4 w-4" style="accent-color: #ff750f">
                                <span class="mt-2 block text-sm font-bold">{{ $service->name }}</span>
                                <span class="block text-xs text-[#555555]">{{ $service->label() }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('service_category')
                        <p class="mt-1.5 text-sm text-red-600" role="alert">{{ $message }}</p>
                    @enderror
                    <div class="mt-6">
                        <button type="submit" class="btn-primary">Lanjut ke Rute</button>
                    </div>
                </form>
            @endif

            @if ($step === 2)
                <form method="POST" action="{{ route('admin.trips.store-step-2') }}">
                    @csrf
                    <x-ui.select label="Pilih rute" name="route_id" :error="$errors->first('route_id')" required>
                        <option value="">— Pilih rute —</option>
                        @foreach ($routes as $route)
                            <option value="{{ $route->id }}" @selected((int) old('route_id', $wizard['route_id'] ?? 0) === $route->id)>
                                {{ $route->origin->name }} &rarr; {{ $route->destination->name }}
                            </option>
                        @endforeach
                    </x-ui.select>
                    <p class="mt-1.5 text-sm text-[#555555]">Hanya rute {{ strtoupper($wizard['service_category']) }} yang lolos aturan lokasi yang ditampilkan.</p>
                    <div class="mt-6 flex gap-3">
                        <button type="submit" class="btn-primary">Lanjut ke Jadwal</button>
                        <a href="{{ route('admin.trips.create', ['step' => 1]) }}" class="btn-secondary">Kembali</a>
                    </div>
                </form>
            @endif

            @if ($step === 3)
                <form method="POST" action="{{ route('admin.trips.store-step-3') }}">
                    @csrf
                    <x-ui.select label="Pilih bus" name="bus_id" :error="$errors->first('bus_id')" required>
                        <option value="">— Pilih bus —</option>
                        @foreach ($buses as $bus)
                            <option value="{{ $bus->id }}" @selected((int) old('bus_id', $wizard['bus_id'] ?? 0) === $bus->id)>
                                {{ $bus->plate_number }} ({{ $bus->model_type->label() }})
                            </option>
                        @endforeach
                    </x-ui.select>
                    <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <x-ui.input label="Berangkat" type="datetime-local" name="departs_at" :value="old('departs_at', $wizard['departs_at'] ?? '')" :error="$errors->first('departs_at')" required />
                        <x-ui.input label="Tiba" type="datetime-local" name="arrives_at" :value="old('arrives_at', $wizard['arrives_at'] ?? '')" :error="$errors->first('arrives_at')" required />
                    </div>
                    <div class="mt-6 flex gap-3">
                        <button type="submit" class="btn-primary">Lanjut ke Harga</button>
                        <a href="{{ route('admin.trips.create', ['step' => 2]) }}" class="btn-secondary">Kembali</a>
                    </div>
                </form>
            @endif

            @if ($step === 4)
                <div class="mb-6 rounded-[var(--radius-sm)] bg-[#faf9f8] p-4 text-sm">
                    <p class="font-bold">{{ $route->origin->name }} &rarr; {{ $route->destination->name }}</p>
                    <p class="mt-1 text-[#555555]">{{ $bus->plate_number }} ({{ $bus->model_type->label() }}) &middot; {{ $seatCount }} kursi digenerate otomatis</p>
                </div>
                <form method="POST" action="{{ route('admin.trips.store-step-4') }}">
                    @csrf
                    <p class="input-label">Harga per kelas (Rp)</p>
                    <div class="space-y-4">
                        @foreach ($allowedClasses as $class)
                            <x-ui.input
                                :label="$class"
                                type="number"
                                :name="'fares['.$class.']'"
                                :value="old('fares.'.$class, $wizard['fares'][$class] ?? '')"
                                :error="$errors->first('fares.'.$class)"
                                min="1000"
                                step="500"
                                placeholder="mis. 195000"
                                required
                            />
                        @endforeach
                    </div>
                    @error('fares')
                        <p class="mt-1.5 text-sm text-red-600" role="alert">{{ $message }}</p>
                    @enderror
                    <div class="mt-6 flex gap-3">
                        <button type="submit" class="btn-primary">Lanjut ke Detail Trip</button>
                        <a href="{{ route('admin.trips.create', ['step' => 3]) }}" class="btn-secondary">Kembali</a>
                    </div>
                </form>
            @endif

            @if ($step === 5)
                <form method="POST" action="{{ route('admin.trips.store-step-5') }}" class="space-y-6">
                    @csrf

                    <div>
                        <p class="input-label">Fasilitas Bus</p>
                        <div class="flex flex-wrap gap-3">
                            @foreach ($availableAmenities as $amenity)
                                @php
                                    $checked = in_array($amenity, old('amenities', $wizard['amenities'] ?? []));
                                @endphp
                                <label class="flex items-center gap-2 rounded-full border px-3 py-1.5 text-sm cursor-pointer transition-all @if($checked) border-[#ff750f] bg-[#ff750f]/10 text-[#ff750f] @else border-[#e6e6e6] text-[#555555] @endif">
                                    <input type="checkbox" name="amenities[]" value="{{ $amenity }}" @if($checked) checked @endif class="sr-only" x-data x-effect="$el.closest('label').classList.toggle('border-[#ff750f]', $el.checked); $el.closest('label').classList.toggle('bg-[#ff750f]/10', $el.checked); $el.closest('label').classList.toggle('text-[#ff750f]', $el.checked)">
                                    {{ $amenity }}
                                </label>
                            @endforeach
                        </div>
                        @error('amenities')
                            <p class="mt-1.5 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                        <div>
                            <p class="input-label">Foto Eksterior (URL)</p>
                            @for ($i = 0; $i < 3; $i++)
                                <input type="url" name="exterior_photos[]" placeholder="https://..." value="{{ old('exterior_photos.'.$i, $wizard['exterior_photos'][$i] ?? '') }}" class="mb-2 w-full rounded-lg border border-[#e6e6e6] px-3 py-2 text-sm">
                            @endfor
                            @error('exterior_photos')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <p class="input-label">Foto Interior (URL)</p>
                            @for ($i = 0; $i < 3; $i++)
                                <input type="url" name="interior_photos[]" placeholder="https://..." value="{{ old('interior_photos.'.$i, $wizard['interior_photos'][$i] ?? '') }}" class="mb-2 w-full rounded-lg border border-[#e6e6e6] px-3 py-2 text-sm">
                            @endfor
                            @error('interior_photos')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <p class="input-label">Foto Fasilitas (URL)</p>
                            @for ($i = 0; $i < 3; $i++)
                                <input type="url" name="facility_photos[]" placeholder="https://..." value="{{ old('facility_photos.'.$i, $wizard['facility_photos'][$i] ?? '') }}" class="mb-2 w-full rounded-lg border border-[#e6e6e6] px-3 py-2 text-sm">
                            @endfor
                            @error('facility_photos')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <x-ui.input label="Alamat Titik Naik" name="origin_address" :value="old('origin_address', $wizard['origin_address'] ?? '')" placeholder="Terminal Bus Ngawi, Jl...." :error="$errors->first('origin_address')" />
                        <x-ui.input label="Alamat Titik Turun" name="destination_address" :value="old('destination_address', $wizard['destination_address'] ?? '')" placeholder="Terminal Kertajaya, Jl...." :error="$errors->first('destination_address')" />
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <x-ui.input label="Nama Titik Istirahat (opsional)" name="rest_stop_name" :value="old('rest_stop_name', $wizard['rest_stop_name'] ?? '')" placeholder="Rest Area KM 50" :error="$errors->first('rest_stop_name')" />
                        <x-ui.input label="Alamat Titik Istirahat (opsional)" name="rest_stop_address" :value="old('rest_stop_address', $wizard['rest_stop_address'] ?? '')" placeholder="Jl. Raya..." :error="$errors->first('rest_stop_address')" />
                    </div>

                    <div>
                        <p class="input-label">Kebijakan Perjalanan</p>
                        <textarea name="policy" rows="4" class="w-full rounded-lg border border-[#e6e6e6] px-3 py-2 text-sm" placeholder="Pembatalan, penggantian jadwal, bagasi, dll.">{{ old('policy', $wizard['policy'] ?? '') }}</textarea>
                        @error('policy')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="btn-primary">Buat Trip</button>
                        <a href="{{ route('admin.trips.create', ['step' => 4]) }}" class="btn-secondary">Kembali</a>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection
