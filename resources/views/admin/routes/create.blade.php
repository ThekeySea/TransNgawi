@extends('layouts.admin')

@section('title', 'Tambah Rute')

@section('content')
    <div class="container-app max-w-2xl">
        <h1 class="text-3xl font-bold tracking-tight">Tambah Rute</h1>
        <p class="mt-2 text-base text-[#555555]">Buat rute baru antar kota dengan kategori layanan.</p>

        <div class="card mt-6 p-6 md:p-8">
            <form method="POST" action="{{ route('admin.routes.store') }}">
                @csrf
                @include('admin.routes._form')
                <div class="mt-6">
                    <button type="submit" class="btn-primary">Simpan Rute</button>
                </div>
            </form>
        </div>
    </div>
@endsection
