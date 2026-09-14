@extends('layouts.customer')

@section('title', 'Profil Saya')

@section('content')
    <section class="bg-[#faf9f8] py-16 md:py-24">
        <div class="container-app">
            <div class="mb-8 max-w-2xl">
                <h1 class="text-3xl font-bold tracking-tight text-[#1a1a1a] sm:text-4xl">Profil Saya</h1>
                <p class="mt-3 text-base text-[#555555]">Kelola data akun dan lihat perjalananmu.</p>
            </div>

            @if (session('status') === 'profile-updated')
                <div class="card mb-6 border-green-200 bg-green-50 px-6 py-4">
                    <p class="text-sm font-medium text-green-700">Profil berhasil diperbarui.</p>
                </div>
            @endif

            <div class="card px-6 py-6 md:px-8">
                <div class="flex flex-col gap-6 sm:flex-row sm:items-center">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-[#ff750f]/10">
                        <span class="text-2xl font-bold text-[#ff750f]">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-xl font-bold text-[#1a1a1a]">{{ auth()->user()->name }}</p>
                        <p class="mt-1 truncate text-sm text-[#555555]">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <div class="mt-6 flex flex-col gap-3 border-t border-[#e6e6e6] pt-6 sm:flex-row">
                    <a href="{{ route('profile.edit') }}" class="btn-primary">Ubah Profil</a>
                    <a href="{{ route('my-trips.index') }}" class="btn-secondary">Perjalanan Saya</a>
                </div>
            </div>
        </div>
    </section>
@endsection
