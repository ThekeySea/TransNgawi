@extends('layouts.admin')

@section('title', 'Laporkan Masalah - '.$bus->plate_number)

@section('content')
    <div class="container-app max-w-2xl">
        <h1 class="mb-2 text-3xl font-bold tracking-tight">Laporkan Masalah</h1>
        <p class="mb-6 text-base text-[#555555]">{{ $bus->plate_number }} &middot; {{ $bus->model_type->label() }}</p>

        <form method="POST" action="{{ route('admin.buses.issues.store', $bus) }}" class="card p-6 md:p-8">
            @csrf
            <x-ui.input
                label="Kategori"
                name="category"
                :value="old('category')"
                :error="$errors->first('category')"
                placeholder="mis. Mesin, Rem, Ban, AC, Interior"
                required
            />

            <div class="mt-5">
                <x-ui.input
                    label="Deskripsi"
                    name="description"
                    :value="old('description')"
                    :error="$errors->first('description')"
                    placeholder="Jelaskan masalah yang ditemukan..."
                    required
                />
            </div>

            <div class="mt-5">
                <x-ui.select label="Tingkat Keparahan" name="severity" :error="$errors->first('severity')" required>
                    <option value="">— Pilih tingkat —</option>
                    @foreach ($severities as $severity)
                        <option value="{{ $severity->value }}" @selected(old('severity') === $severity->value)>{{ $severity->label() }}</option>
                    @endforeach
                </x-ui.select>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit" class="btn-primary">Simpan Laporan</button>
                <a href="{{ route('admin.buses.issues.index', $bus) }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
