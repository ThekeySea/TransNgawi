@extends('layouts.customer')

@section('title', 'Beranda')

@section('content')
    {{-- Hero Section --}}
    <section class="relative -mt-16 min-h-[560px] lg:-mt-20 lg:min-h-[780px]">
        <img
            src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=1920&q=80"
            alt="Bus TransNgawi melintasi jalan antarkota"
            class="absolute inset-0 h-full w-full object-cover"
        >
        <div class="hero-overlay"></div>

        <div class="container-app relative z-10 flex min-h-[560px] flex-col items-center justify-center px-5 pt-28 pb-56 text-center lg:min-h-[780px] md:pb-64">
            <div class="max-w-3xl">
                <h1 class="text-3xl font-extrabold leading-tight tracking-tight text-white sm:text-5xl lg:text-6xl">
                    Perjalanan Nyaman,<br class="hidden sm:block">
                    Tanpa Bikin Kantong Berat.
                </h1>
                <p class="mx-auto mt-5 max-w-xl text-sm leading-relaxed text-neutral-200 sm:text-base md:text-lg">
                    Pesan tiket bus TransNgawi dengan mudah, pilih perjalanan yang sesuai kebutuhan, dan nikmati perjalanan antarkota dengan kenyamanan yang lebih masuk akal.
                </p>
                <div class="mt-6 flex justify-center">
                    <a href="{{ route('search.index') }}" class="btn-primary px-6 py-2.5 text-sm shadow-lg sm:px-8 sm:py-3 sm:text-base">Cari Perjalanan</a>
                </div>
            </div>
        </div>

        {{-- Booking Widget Overlap --}}
        <div class="absolute bottom-0 left-0 right-0 z-30 translate-y-1/2">
            <div class="container-app">
                <x-booking.booking-widget class="mx-auto max-w-4xl" />
            </div>
        </div>
    </section>

    {{-- Hal Yang Perlu Diperhatikan Section --}}
    <section class="bg-surface pt-44 pb-14 md:pt-56 md:pb-24">
        <div class="container-app">
            <h2 class="text-center text-2xl font-bold tracking-tight text-text sm:text-3xl md:text-4xl">Hal Yang Perlu Diperhatikan</h2>

            <div class="mt-10 grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-4">
                <div class="card p-4 sm:p-5 md:p-7">
                    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-full bg-[#ff750f]/10 text-[#ff750f]">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" /></svg>
                    </div>
                    <h3 class="text-sm font-bold text-text sm:text-base md:text-lg">Tiket & Identitas</h3>
                    <p class="mt-1 text-xs leading-relaxed text-text-muted sm:text-sm">
                        Pastikan nama penumpang pada tiket sesuai dengan identitas resmi yang digunakan saat perjalanan.
                    </p>
                </div>

                <div class="card p-4 sm:p-5 md:p-7">
                    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-full bg-[#ff750f]/10 text-[#ff750f]">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-sm font-bold text-text sm:text-base md:text-lg">Waktu Keberangkatan</h3>
                    <p class="mt-1 text-xs leading-relaxed text-text-muted sm:text-sm">
                        Datanglah minimal 30 menit lebih awal sebelum jadwal keberangkatan agar proses boarding berjalan lancar.
                    </p>
                </div>

                <div class="card p-4 sm:p-5 md:p-7">
                    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-full bg-[#ff750f]/10 text-[#ff750f]">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                    </div>
                    <h3 class="text-sm font-bold text-text sm:text-base md:text-lg">Bagasi & Barang Bawaan</h3>
                    <p class="mt-1 text-xs leading-relaxed text-text-muted sm:text-sm">
                        Simpanlah barang berharga Anda di tas jinjing. TransNgawi menyediakan bagasi yang aman untuk koper dan tas besar.
                    </p>
                </div>

                <div class="card p-4 sm:p-5 md:p-7">
                    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-full bg-[#ff750f]/10 text-[#ff750f]">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-sm font-bold text-text sm:text-base md:text-lg">Informasi Perjalanan</h3>
                    <p class="mt-1 text-xs leading-relaxed text-text-muted sm:text-sm">
                        Selalu periksa detail rute, jadwal, nomor kursi, dan titik keberangkatan pada tiket digital Anda sebelum berangkat.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Tata Cara Pemesanan Tiket --}}
    <section class="bg-surface py-14 md:py-24">
        <div class="container-app">
            <div class="mb-10 text-center md:mb-14">
                <h2 class="text-2xl font-bold tracking-tight text-text sm:text-3xl md:text-4xl">Tata Cara Pemesanan Tiket</h2>
                <p class="mx-auto mt-3 max-w-xl text-xs leading-relaxed text-text-muted sm:text-sm md:text-base">Empat langkah mudah memesan tiket perjalanan bersama TransNgawi.</p>
            </div>

            {{-- Milestone Pipeline --}}
            <div class="relative mt-12 md:mt-16">

                {{-- Desktop Horizontal Connecting Line --}}
                <div class="pointer-events-none absolute left-0 right-0 top-5 hidden h-px bg-[#e6e6e6] lg:block"></div>
                <div class="pointer-events-none absolute top-5 hidden h-0.5 bg-[#ff750f] lg:block" style="left: 12.5%; right: 12.5%;"></div>

                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4 lg:gap-6">

                    {{-- Step 1 --}}
                    <div class="relative flex flex-col text-center lg:text-center">
                        {{-- Mobile Vertical Line --}}
                        <div class="pointer-events-none absolute left-5 top-10 h-[calc(100%+2rem)] w-0.5 bg-[#e6e6e6] sm:hidden"></div>

                        <div class="relative z-10 mx-auto mb-4 flex h-10 w-10 items-center justify-center rounded-full bg-[#ff750f] text-sm font-bold text-white shadow-md shadow-[#ff750f]/25 lg:mx-auto">01</div>
                        <div class="card mx-auto flex w-full max-w-[280px] flex-col items-center p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-md sm:p-6">
                            <div class="mb-3 flex h-11 w-11 items-center justify-center rounded-2xl bg-[#ff750f]/10">
                                <svg class="h-5 w-5 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <h3 class="text-sm font-bold text-text sm:text-base">Buat Akun / Login</h3>
                            <p class="mt-1.5 text-xs leading-relaxed text-text-muted">Daftar atau masuk ke akun TransNgawi untuk kemudahan transaksi, penyimpanan riwayat, dan akses e-tiket.</p>
                        </div>
                    </div>

                    {{-- Step 2 --}}
                    <div class="relative flex flex-col text-center lg:text-center">
                        <div class="pointer-events-none absolute left-5 top-10 h-[calc(100%+2rem)] w-0.5 bg-[#e6e6e6] sm:hidden"></div>

                        <div class="relative z-10 mx-auto mb-4 flex h-10 w-10 items-center justify-center rounded-full bg-[#ff750f] text-sm font-bold text-white shadow-md shadow-[#ff750f]/25 lg:mx-auto">02</div>
                        <div class="card mx-auto flex w-full max-w-[280px] flex-col items-center p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-md sm:p-6">
                            <div class="mb-3 flex h-11 w-11 items-center justify-center rounded-2xl bg-[#ff750f]/10">
                                <svg class="h-5 w-5 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </div>
                            <h3 class="text-sm font-bold text-text sm:text-base">Cari &amp; Pilih Perjalanan</h3>
                            <p class="mt-1.5 text-xs leading-relaxed text-text-muted">Tentukan rute asal, tujuan, tanggal keberangkatan, serta pilih armada bus favoritmu (Pleton atau Ksatria).</p>
                        </div>
                    </div>

                    {{-- Step 3 --}}
                    <div class="relative flex flex-col text-center lg:text-center">
                        <div class="pointer-events-none absolute left-5 top-10 h-[calc(100%+2rem)] w-0.5 bg-[#e6e6e6] sm:hidden"></div>

                        <div class="relative z-10 mx-auto mb-4 flex h-10 w-10 items-center justify-center rounded-full bg-[#ff750f] text-sm font-bold text-white shadow-md shadow-[#ff750f]/25 lg:mx-auto">03</div>
                        <div class="card mx-auto flex w-full max-w-[280px] flex-col items-center p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-md sm:p-6">
                            <div class="mb-3 flex h-11 w-11 items-center justify-center rounded-2xl bg-[#ff750f]/10">
                                <svg class="h-5 w-5 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" /></svg>
                            </div>
                            <h3 class="text-sm font-bold text-text sm:text-base">Pilih Kursi &amp; Isi Data</h3>
                            <p class="mt-1.5 text-xs leading-relaxed text-text-muted">Tentukan posisi kursi favorit secara visual pada denah bus interaktif dan lengkapi data penumpang.</p>
                        </div>
                    </div>

                    {{-- Step 4 --}}
                    <div class="relative flex flex-col text-center lg:text-center">
                        <div class="relative z-10 mx-auto mb-4 flex h-10 w-10 items-center justify-center rounded-full bg-[#ff750f] text-sm font-bold text-white shadow-md shadow-[#ff750f]/25 lg:mx-auto">04</div>
                        <div class="card mx-auto flex w-full max-w-[280px] flex-col items-center p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-md sm:p-6">
                            <div class="mb-3 flex h-11 w-11 items-center justify-center rounded-2xl bg-[#ff750f]/10">
                                <svg class="h-5 w-5 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                            </div>
                            <h3 class="text-sm font-bold text-text sm:text-base">Bayar &amp; Dapatkan E-Tiket</h3>
                            <p class="mt-1.5 text-xs leading-relaxed text-text-muted">Selesaikan pembayaran secara instan. E-tiket dengan QR Code akan otomatis terbit untuk ditunjukkan saat boarding.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    {{-- About CTA Section --}}
    <section class="bg-surface-elevated py-14 md:py-24">
        <div class="container-app">
            <div class="card overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <div class="relative min-h-[200px] sm:min-h-[240px] lg:min-h-[400px] bg-cover bg-center bg-no-repeat" style="background-image: url('https://images.unsplash.com/photo-1570125909232-eb263c188f7e?q=80&w=1171&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')">
                    </div>
                    <div class="flex flex-col justify-center p-6 sm:p-8 md:p-10 lg:p-14">
                        <h2 class="text-xl font-bold tracking-tight text-text sm:text-2xl md:text-3xl">Kenal Lebih Dekat dengan TransNgawi</h2>
                        <p class="mt-3 text-xs leading-relaxed text-text-muted sm:text-sm md:text-base">
                            TransNgawi hadir untuk menghadirkan perjalanan antarkota yang nyaman, mudah dipesan, dan tetap masuk akal untuk kebutuhan perjalanan sehari-hari.
                        </p>
                        <div class="mt-6 sm:mt-8">
                            <a href="{{ route('about.index') }}" class="inline-flex items-center justify-center rounded-[var(--radius-sm)] border-2 border-[#1a1a1a] bg-transparent px-6 py-2.5 text-sm font-semibold text-[#1a1a1a] transition-all duration-200 hover:border-[#ff750f] hover:bg-[#ff750f] hover:text-white sm:px-8 sm:py-3 sm:text-base">Tentang TransNgawi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
