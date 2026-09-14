@extends('layouts.customer')

@section('title', 'Lacak Tiket')

@section('content')
    <section class="bg-[#faf9f8] py-16 md:py-24">
        <div class="container-app">
            <div class="mb-8 max-w-2xl">
                <h1 class="text-3xl font-bold tracking-tight text-[#1a1a1a] sm:text-4xl">Lacak Tiket</h1>
                <p class="mt-3 text-base text-[#555555]">Lihat riwayat pembelian tiket dan status perjalananmu.</p>
            </div>

            @if ($guest)
                {{-- Guest State: Prompt to login/register --}}
                <div class="mx-auto max-w-md">
                    <div class="card px-6 py-10 text-center md:px-10">
                        <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-[#ff750f]/10">
                            <svg class="h-8 w-8 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-[#1a1a1a]">Masuk untuk Melihat Tiket</h2>
                        <p class="mt-3 text-sm text-[#555555]">
                            Kamu perlu masuk atau membuat akun terlebih dahulu untuk melihat riwayat pembelian tiketmu.
                        </p>
                        <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
                            <a href="{{ route('login') }}" class="btn-primary">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                                </svg>
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="btn-secondary">
                                Buat Akun
                            </a>
                        </div>
                    </div>

                    {{-- Guest: code lookup with phone/email --}}
                    <div class="mt-8">
                        <div class="card px-6 py-6 md:px-8">
                            <h3 class="text-lg font-bold text-[#1a1a1a]">Lacak dengan Kode Booking</h3>
                            <p class="mt-1 text-sm text-[#555555]">Masukkan kode booking dan nomor telepon atau email untuk verifikasi.</p>
                            
                            <form action="{{ route('my-trips.search') }}" method="POST" class="mt-4 space-y-4">
                                @csrf
                                <div>
                                    <label for="booking_code" class="block text-sm font-semibold text-[#1a1a1a]">Kode Booking</label>
                                    <input
                                        type="text"
                                        id="booking_code"
                                        name="booking_code"
                                        value="{{ old('booking_code') }}"
                                        placeholder="Contoh: TN4ED210"
                                        class="input mt-1"
                                        required
                                    >
                                    @error('booking_code')
                                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="identifier" class="block text-sm font-semibold text-[#1a1a1a]">Nomor Telepon atau Email</label>
                                    <input
                                        type="text"
                                        id="identifier"
                                        name="identifier"
                                        value="{{ old('identifier') }}"
                                        placeholder="Contoh: 08123456789 atau email@contoh.com"
                                        class="input mt-1"
                                        required
                                    >
                                    @error('identifier')
                                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button type="submit" class="btn-primary w-full">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                                    </svg>
                                    Lacak Tiket
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Guest: search result --}}
                @if ($searchResult)
                    <div class="mx-auto mt-8 max-w-2xl">
                        <h3 class="mb-4 text-lg font-bold text-[#1a1a1a]">Hasil Pencarian</h3>
                        @include('customer.account._booking-card', ['booking' => $searchResult])
                    </div>
                @endif
            @else
                {{-- Authenticated State: Show purchase history --}}
                <div class="mb-6 flex gap-2">
                    <a href="{{ route('my-trips.index', ['tab' => 'upcoming']) }}" class="rounded-lg px-4 py-2 text-sm font-semibold transition-colors @if($tab === 'upcoming') bg-[#ff750f] text-white @else bg-[#e6e6e6] text-[#1a1a1a] hover:bg-[#d4d4d4] @endif">Mendatang</a>
                    <a href="{{ route('my-trips.index', ['tab' => 'past']) }}" class="rounded-lg px-4 py-2 text-sm font-semibold transition-colors @if($tab === 'past') bg-[#ff750f] text-white @else bg-[#e6e6e6] text-[#1a1a1a] hover:bg-[#d4d4d4] @endif">Selesai</a>
                    <a href="{{ route('my-trips.index', ['tab' => 'all']) }}" class="rounded-lg px-4 py-2 text-sm font-semibold transition-colors @if($tab === 'all') bg-[#ff750f] text-white @else bg-[#e6e6e6] text-[#1a1a1a] hover:bg-[#d4d4d4] @endif">Semua</a>
                </div>

                @if ($bookings->isEmpty())
                    <div class="card px-6 py-12 text-center md:px-8">
                        <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-[#e6e6e6]">
                            <svg class="h-6 w-6 text-[#555555]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z"/>
                            </svg>
                        </div>
                        <p class="text-base font-bold text-[#1a1a1a]">Belum ada tiket di sini.</p>
                        <p class="mt-2 text-sm text-[#555555]">
                            @if ($tab === 'upcoming')
                                Kamu belum memiliki tiket untuk perjalanan mendatang.
                            @elseif ($tab === 'past')
                                Belum ada riwayat perjalanan yang selesai.
                            @else
                                Belum ada riwayat pembelian tiket.
                            @endif
                        </p>
                        <a href="{{ route('search.index') }}" class="btn-primary mt-6">Cari Perjalanan</a>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach ($bookings as $booking)
                            @include('customer.account._booking-card', ['booking' => $booking])
                        @endforeach
                    </div>
                @endif

                {{-- Also allow code lookup --}}
                <div class="mt-8 border-t border-[#e6e6e6] pt-6">
                    <div class="card px-6 py-6 md:px-8">
                        <h3 class="text-lg font-bold text-[#1a1a1a]">Cari Tiket Lain</h3>
                        <p class="mt-1 text-sm text-[#555555]">Masukkan kode booking dan nomor telepon atau email untuk verifikasi.</p>
                        
                        <form action="{{ route('my-trips.search') }}" method="POST" class="mt-4 space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="booking_code" class="block text-sm font-semibold text-[#1a1a1a]">Kode Booking</label>
                                    <input
                                        type="text"
                                        id="booking_code"
                                        name="booking_code"
                                        value="{{ old('booking_code') }}"
                                        placeholder="Contoh: TN4ED210"
                                        class="input mt-1"
                                        required
                                    >
                                    @error('booking_code')
                                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="identifier" class="block text-sm font-semibold text-[#1a1a1a]">Nomor Telepon atau Email</label>
                                    <input
                                        type="text"
                                        id="identifier"
                                        name="identifier"
                                        value="{{ old('identifier') }}"
                                        placeholder="Contoh: 08123456789"
                                        class="input mt-1"
                                        required
                                    >
                                    @error('identifier')
                                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn-primary">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                                </svg>
                                Cari Tiket
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Auth: search result --}}
                @if ($searchResult)
                    <div class="mt-8">
                        <h3 class="mb-4 text-lg font-bold text-[#1a1a1a]">Hasil Pencarian</h3>
                        @include('customer.account._booking-card', ['booking' => $searchResult])
                    </div>
                @endif
            @endif
        </div>
    </section>
@endsection
