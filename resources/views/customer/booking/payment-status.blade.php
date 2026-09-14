@extends('layouts.customer')

@section('title', 'Status Pembayaran')

@section('content')
    <section class="section-spacing bg-surface">
        <div class="container-app">
            <div class="mx-auto max-w-lg text-center">
                <div class="mb-6 flex justify-center">
                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-amber-100">
                        <svg class="h-8 w-8 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>

                <h1 class="text-2xl font-bold text-text sm:text-3xl">Menunggu Verifikasi</h1>
                <p class="mt-4 text-sm text-text-muted">
                    Pembayaran Anda sedang menunggu verifikasi oleh admin. Anda akan menerima notifikasi setelah pembayaran dikonfirmasi.
                </p>

                <div class="mt-8 card">
                    <div class="card-body">
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-text-muted">Kode Booking</dt>
                                <dd class="font-bold text-text">{{ $booking->code }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-text-muted">Total</dt>
                                <dd class="font-bold text-brand">Rp {{ number_format($booking->total, 0, ',', '.') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-text-muted">Status</dt>
                                <dd>
                                    <span class="inline-flex items-center rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-800">
                                        Menunggu Verifikasi
                                    </span>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
                    <a href="{{ route('home') }}" class="btn-secondary">Kembali ke Beranda</a>
                    <a href="{{ route('my-trips.index') }}" class="btn-primary">Lihat Perjalanan Saya</a>
                </div>
            </div>
        </div>
    </section>
@endsection
