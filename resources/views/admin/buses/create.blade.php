@extends('layouts.admin')

@section('title', 'Tambah Bus')

@section('content')
    <div class="container-app max-w-2xl">
        <h1 class="mb-6 text-3xl font-bold tracking-tight">Tambah Bus</h1>

        <form method="POST" action="{{ route('admin.buses.store') }}" class="card p-6 md:p-8">
            @csrf
            @include('admin.buses._form')
            <div class="mt-6 flex gap-3">
                <button type="submit" class="btn-primary">Simpan</button>
                <a href="{{ route('admin.buses.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
