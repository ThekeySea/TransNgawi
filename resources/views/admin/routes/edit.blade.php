@extends('layouts.admin')

@section('title', 'Ubah Rute')

@section('content')
    <div class="container-app max-w-2xl">
        <h1 class="text-3xl font-bold tracking-tight">Ubah Rute</h1>
        <p class="mt-2 text-base text-[#555555]">{{ $route->origin->name }} &rarr; {{ $route->destination->name }}</p>

        <div class="card mt-6 p-6 md:p-8">
            <form method="POST" action="{{ route('admin.routes.update', $route) }}">
                @csrf
                @method('PUT')
                @include('admin.routes._form')
                <div class="mt-6">
                    <button type="submit" class="btn-primary">Perbarui Rute</button>
                </div>
            </form>
        </div>
    </div>
@endsection
