@extends('layouts.admin')

@section('title', 'Tambah Lokasi')

@section('content')
    <div class="container-app max-w-2xl">
        <h1 class="mb-6 text-3xl font-bold tracking-tight">Tambah Lokasi</h1>

        <form method="POST" action="{{ route('admin.locations.store') }}" class="card p-6 md:p-8">
            @csrf
            @include('admin.locations._form')
            <div class="mt-6 flex gap-3">
                <button type="submit" class="btn-primary">Simpan</button>
                <a href="{{ route('admin.locations.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
