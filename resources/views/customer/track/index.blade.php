@extends('layouts.customer')

@section('title', 'Lacak Tiket')

@section('content')
    <section class="section-spacing bg-surface">
        <div class="container-app">
            <div class="mx-auto max-w-lg text-center">
                <div class="mb-6 flex justify-center">
                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-brand-muted text-brand">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                        </svg>
                    </div>
                </div>

                <h1 class="text-2xl font-bold text-text sm:text-3xl">Lacak Tiket</h1>
                <p class="mt-4 text-sm text-text-muted">
                    Masukkan kode booking Anda untuk melihat status pemesanan dan pembayaran.
                </p>

                <form action="{{ route('track.lookup') }}" method="POST" class="mt-8">
                    @csrf
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <div class="flex-1">
                            <input
                                type="text"
                                name="code"
                                id="code"
                                value="{{ old('code') }}"
                                placeholder="Contoh: TNX8F29"
                                class="input"
                                required
                                autofocus
                            >
                            @error('code')
                                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="btn-primary">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                            </svg>
                            Lacak
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
