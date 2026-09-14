@extends('layouts.customer')

@section('title', 'Bantuan')

@section('content')
    <section class="section-spacing bg-surface">
        <div class="container-app">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-text sm:text-3xl">Bantuan</h1>
                <p class="mt-2 text-sm text-text-muted">Hubungi kami untuk mendapatkan bantuan terkait pemesanan Anda.</p>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                {{-- Main: Create Session --}}
                <div class="lg:col-span-2">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-lg font-bold text-text">Buat Sesi Bantuan Baru</h3>

                            <form action="{{ route('help.store') }}" method="POST" class="mt-4 space-y-4">
                                @csrf
                                <div>
                                    <label for="topic" class="input-label">Topik</label>
                                    <select name="topic" id="topic" class="select" required>
                                        <option value="">Pilih topik</option>
                                        @foreach ($topics as $topic)
                                            <option value="{{ $topic }}" {{ old('topic') === $topic ? 'selected' : '' }}>{{ $topic }}</option>
                                        @endforeach
                                    </select>
                                    @error('topic')
                                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="booking_id" class="input-label">Kode Booking (opsional)</label>
                                    <select name="booking_id" id="booking_id" class="select">
                                        <option value="">Tidak terkait booking</option>
                                        @foreach ($bookings as $booking)
                                            <option value="{{ $booking->id }}" {{ old('booking_id') == $booking->id ? 'selected' : '' }}>
                                                {{ $booking->code }} — {{ $booking->trip->route->origin->name }} → {{ $booking->trip->route->destination->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('booking_id')
                                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="subject" class="input-label">Subjek</label>
                                    <input type="text" name="subject" id="subject" class="input" value="{{ old('subject') }}" placeholder="Ringkasan masalah Anda" required>
                                    @error('subject')
                                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="message" class="input-label">Pesan</label>
                                    <textarea name="message" id="message" rows="4" class="input" placeholder="Jelaskan masalah Anda..." required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit" class="btn-primary">Kirim</button>
                            </form>
                        </div>
                    </div>

                    {{-- Session History --}}
                    @if ($sessions->isNotEmpty())
                        <div class="mt-6 card">
                            <div class="card-body">
                                <h3 class="text-lg font-bold text-text">Riwayat Sesi Bantuan</h3>
                                <div class="mt-4 divide-y divide-border">
                                    @foreach ($sessions as $session)
                                        <a href="{{ route('help.show', $session) }}" class="flex items-center justify-between py-3 transition-colors hover:bg-surface">
                                            <div class="min-w-0 flex-1">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-sm font-semibold text-text">{{ $session->subject }}</span>
                                                    @php
                                                        $statusVariant = match($session->status) {
                                                            'WAITING' => 'badge-warning',
                                                            'ACTIVE' => 'badge-info',
                                                            'RESOLVED', 'CLOSED' => 'badge-neutral',
                                                            default => 'badge-neutral',
                                                        };
                                                    @endphp
                                                    <span class="{{ $statusVariant }} text-[10px]">{{ $session->status }}</span>
                                                </div>
                                                <p class="mt-1 text-xs text-text-muted">{{ $session->topic }} · {{ $session->created_at->diffForHumans() }}</p>
                                            </div>
                                            <svg class="h-4 w-4 shrink-0 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Sidebar: Info --}}
                <div class="lg:col-span-1">
                    <div class="card sticky top-24">
                        <div class="card-body">
                            <h3 class="text-lg font-bold text-text">Informasi</h3>
                            <div class="mt-4 space-y-4 text-sm text-text-muted">
                                <p>Tim support kami akan merespons sesi bantuan Anda sesegera mungkin.</p>
                                <p>Pastikan Anda memberikan informasi yang cukup agar kami dapat membantu dengan cepat.</p>
                                <p>Jika terkait pemesanan, pilih kode booking yang relevan agar kami dapat memverifikasi lebih mudah.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
