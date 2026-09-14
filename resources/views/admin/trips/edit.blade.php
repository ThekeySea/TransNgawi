@extends('layouts.admin')

@section('title', 'Ubah Trip')

@section('content')
    <div class="container-app max-w-2xl">
        <h1 class="text-3xl font-bold tracking-tight">Ubah Trip</h1>
        <p class="mt-2 text-base text-[#555555]">{{ $trip->route->origin->name }} &rarr; {{ $trip->route->destination->name }}</p>

        <div class="card mt-6 p-6 md:p-8">
            <div class="mb-6 rounded-[var(--radius-sm)] bg-[#faf9f8] p-4 text-sm">
                <p class="font-bold">{{ $trip->route->origin->name }} &rarr; {{ $trip->route->destination->name }}</p>
                <p class="mt-1 text-[#555555]">{{ $trip->route->service_category->name }} &middot; {{ $trip->seats_count }} kursi</p>
            </div>

            <form method="POST" action="{{ route('admin.trips.update', $trip) }}">
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

                <div class="mt-6 flex gap-3">
                    <button type="submit" class="btn-primary">Perbarui Trip</button>
                    <a href="{{ route('admin.trips.index') }}" class="btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection
