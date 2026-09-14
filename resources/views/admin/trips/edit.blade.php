@extends('layouts.admin')

@section('title', 'Ubah Trip')

@section('content')
    <div class="container-app max-w-2xl">
        <h1 class="text-3xl font-bold tracking-tight">Ubah Trip</h1>
        <p class="mt-2 text-base text-[#555555]">{{ $trip->route->origin->name }} &rarr; {{ $trip->route->destination->name }}</p>

        <div class="card mt-6 p-6 md:p-8">
            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <p class="font-bold">Terjadi kesalahan:</p>
                    <ul class="mt-1 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-6 rounded-[var(--radius-sm)] bg-[#faf9f8] p-4 text-sm">
                <p class="font-bold">{{ $trip->route->origin->name }} &rarr; {{ $trip->route->destination->name }}</p>
                <p class="mt-1 text-[#555555]">{{ $trip->route->service_category->name }} &middot; {{ $trip->seats_count }} kursi</p>
            </div>

            <form method="POST" action="{{ route('admin.trips.update', $trip) }}" x-data="{ checkedAmenities: @js(old('amenities', $trip->amenities ?? [])) }">
                @csrf
                @method('PUT')

                <x-ui.select label="Bus" name="bus_id" :error="$errors->first('bus_id')" required>
                    <option value="">— Pilih bus —</option>
                    @foreach ($buses as $bus)
                        <option value="{{ $bus->id }}" @selected((int) old('bus_id', $trip->bus_id) === $bus->id)>
                            {{ $bus->plate_number }} ({{ $bus->model_type->label() }}) — {{ $bus->status->label() }}
                        </option>
                    @endforeach
                </x-ui.select>

                <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-ui.input
                        label="Berangkat"
                        type="datetime-local"
                        name="departs_at"
                        :value="old('departs_at', $trip->departs_at?->format('Y-m-d\TH:i'))"
                        :error="$errors->first('departs_at')"
                        required
                    />
                    <x-ui.input
                        label="Tiba"
                        type="datetime-local"
                        name="arrives_at"
                        :value="old('arrives_at', $trip->arrives_at?->format('Y-m-d\TH:i'))"
                        :error="$errors->first('arrives_at')"
                        required
                    />
                </div>

                <div class="mt-6">
                    <p class="input-label">Harga per kelas (Rp)</p>
                    <div class="space-y-4">
                        @foreach ($allowedClasses as $class)
                            <x-ui.input
                                :label="$class"
                                type="number"
                                :name="'fares['.$class.']'"
                                :value="old('fares.'.$class, $fareMap[$class] ?? '')"
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
                </div>

                <hr class="my-8 border-[#e6e6e6]">

                <div>
                    <p class="input-label">Fasilitas Bus</p>
                    <div class="flex flex-wrap gap-3">
                        @foreach ($availableAmenities as $amenity)
                            <label class="flex items-center gap-2 rounded-full border px-3 py-1.5 text-sm cursor-pointer transition-all"
                                :class="checkedAmenities.includes('{{ $amenity }}') ? 'border-[#ff750f] bg-[#ff750f]/10 text-[#ff750f]' : 'border-[#e6e6e6] text-[#555555]'">
                                <input type="checkbox" name="amenities[]" value="{{ $amenity }}" x-model="checkedAmenities" class="sr-only">
                                {{ $amenity }}
                            </label>
                        @endforeach
                    </div>
                    @error('amenities')
                        <p class="mt-1.5 text-sm text-red-600" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-3">
                    <div>
                        <p class="input-label">Foto Eksterior (URL)</p>
                        @for ($i = 0; $i < 3; $i++)
                            <input type="url" name="exterior_photos[]" placeholder="https://..." value="{{ old('exterior_photos.'.$i, $trip->exterior_photos[$i] ?? '') }}" class="mb-2 w-full rounded-lg border border-[#e6e6e6] px-3 py-2 text-sm">
                        @endfor
                        @error('exterior_photos')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <p class="input-label">Foto Interior (URL)</p>
                        @for ($i = 0; $i < 3; $i++)
                            <input type="url" name="interior_photos[]" placeholder="https://..." value="{{ old('interior_photos.'.$i, $trip->interior_photos[$i] ?? '') }}" class="mb-2 w-full rounded-lg border border-[#e6e6e6] px-3 py-2 text-sm">
                        @endfor
                        @error('interior_photos')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <p class="input-label">Foto Fasilitas (URL)</p>
                        @for ($i = 0; $i < 3; $i++)
                            <input type="url" name="facility_photos[]" placeholder="https://..." value="{{ old('facility_photos.'.$i, $trip->facility_photos[$i] ?? '') }}" class="mb-2 w-full rounded-lg border border-[#e6e6e6] px-3 py-2 text-sm">
                        @endfor
                        @error('facility_photos')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="submit" class="btn-primary">Perbarui Trip</button>
                    <a href="{{ route('admin.trips.index') }}" class="btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection
