@extends('layouts.customer')

@section('title', 'Tentang TransNgawi')

@section('content')
    {{-- Hero --}}
    <section class="relative -mt-16 overflow-hidden bg-[#0a0a0a] py-28 lg:-mt-20 lg:py-36">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-br from-[#ff750f]/20 via-transparent to-transparent"></div>
        </div>
        <div class="container-app relative z-10">
            <div class="max-w-3xl">
                <h1 class="text-4xl font-extrabold leading-tight tracking-tight text-white sm:text-5xl lg:text-6xl">
                    Tentang TransNgawi
                </h1>
                <p class="mt-6 max-w-xl text-base leading-relaxed text-neutral-400 sm:text-lg">
                    Kami percaya setiap perjalanan harus nyaman, mudah, dan masuk akal, tanpa kompromi.
                </p>
            </div>
        </div>
    </section>

    {{-- Visi & Misi --}}
    <section class="bg-[#faf9f8] py-16 md:py-24">
        <div class="container-app">
            <div class="mb-12 max-w-2xl">
                <h2 class="text-3xl font-bold tracking-tight text-[#1a1a1a] sm:text-4xl">Visi & Misi</h2>
                <p class="mt-3 text-base text-[#555555]">Langkah kami dimulai dari tekad yang jelas.</p>
            </div>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                {{-- Visi --}}
                <div class="card flex flex-col overflow-hidden">
                    <div class="bg-[#ff750f] px-6 py-4 md:px-8">
                        <p class="text-xs font-bold uppercase tracking-widest text-white/70">Visi</p>
                    </div>
                    <div class="flex flex-1 flex-col justify-center p-6 md:p-8">
                        <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-[#ff750f]/10">
                            <svg class="h-7 w-7 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-[#1a1a1a]">Menjadi Solusi Perjalanan #1</h3>
                        <p class="mt-3 text-sm leading-relaxed text-[#555555]">
                            Menjadi platform pemesanan tiket bus antarkota paling tepercaya dan mudah diakses oleh seluruh masyarakat Indonesia, dengan standar kenyamanan yang konsisten di setiap perjalanan.
                        </p>
                    </div>
                </div>

                {{-- Misi --}}
                <div class="card flex flex-col overflow-hidden">
                    <div class="bg-[#1a1a1a] px-6 py-4 md:px-8">
                        <p class="text-xs font-bold uppercase tracking-widest text-[#ff750f]">Misi</p>
                    </div>
                    <div class="flex flex-1 flex-col justify-center p-6 md:p-8">
                        <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-[#ff750f]/10">
                            <svg class="h-7 w-7 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-[#1a1a1a]">Mewujudkan Kenyamanan untuk Semua</h3>
                        <div class="mt-3 space-y-2 text-sm leading-relaxed text-[#555555]">
                            <p>• Menyediakan harga yang jujur dan transparan tanpa biaya tersembunyi.</p>
                            <p>• Memberikan pilihan kelas yang sesuai dengan berbagai kebutuhan pelanggan.</p>
                            <p>• Membangun pengalaman digital yang mudah dari pencarian hingga keberangkatan.</p>
                            <p>• Menjaga standar armada dan pelayanan demi keselamatan bersama.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Keunggulan Kami — Bento Grid --}}
    <section class="bg-white py-16 md:py-24">
        <div class="container-app">
            <div class="mb-12 max-w-2xl">
                <h2 class="text-3xl font-bold tracking-tight text-[#1a1a1a] sm:text-4xl">Keunggulan Kami</h2>
                <p class="mt-3 text-base text-[#555555]">Alasan memilih TransNgawi untuk perjalananmu.</p>
            </div>

            {{-- Bento Grid --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

                {{-- 1. Value & Transparansi Terbaik — Hero Card (col-span-2) --}}
                <article class="group flex flex-col justify-between overflow-hidden rounded-2xl border border-[#e6e6e6] bg-[#faf9f8] p-6 transition-all duration-300 hover:-translate-y-0.5 hover:border-[#ff750f]/30 hover:shadow-lg focus-within:ring-2 focus-within:ring-[#ff750f] sm:p-8 md:col-span-2" tabindex="0">
                    <div>
                        <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-[#ff750f]/10 transition-transform duration-300 group-hover:scale-105">
                            <svg class="h-6 w-6 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-[#1a1a1a]">Value & Transparansi Terbaik</h3>
                        <p class="mt-3 max-w-lg text-sm leading-relaxed text-[#555555]">
                            Bukan sekadar terjangkau, kami menawarkan fasilitas dan kenyamanan maksimal di setiap rute tanpa biaya tersembunyi.
                        </p>
                    </div>
                    <div class="mt-6 flex items-center gap-3">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-600 ring-1 ring-amber-200">
                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                            </svg>
                            Jaminan Value
                        </span>
                    </div>
                </article>

                {{-- 2. Booking Instan — Top Right --}}
                <article class="group flex flex-col overflow-hidden rounded-2xl border border-[#e6e6e6] bg-[#faf9f8] p-6 transition-all duration-300 hover:-translate-y-0.5 hover:border-[#ff750f]/30 hover:shadow-lg focus-within:ring-2 focus-within:ring-[#ff750f] sm:p-8" tabindex="0">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-[#ff750f]/10 transition-transform duration-300 group-hover:scale-105">
                        <svg class="h-6 w-6 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#1a1a1a]">Booking Instan</h3>
                    <p class="mt-2 flex-1 text-sm leading-relaxed text-[#555555]">
                        Pesan tiket dalam hitungan menit, langsung terbit e-tiket tanpa antre.
                    </p>
                    <div class="mt-4 inline-flex items-center gap-2 self-start rounded-full bg-emerald-50 px-3 py-1.5">
                        <svg class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-xs font-semibold text-emerald-700">Konfirmasi Instan</span>
                    </div>
                </article>

                {{-- 3. Armada Terawat — Row 2 Left --}}
                <article class="group flex flex-col overflow-hidden rounded-2xl border border-[#e6e6e6] bg-[#faf9f8] p-6 transition-all duration-300 hover:-translate-y-0.5 hover:border-[#ff750f]/30 hover:shadow-lg focus-within:ring-2 focus-within:ring-[#ff750f] sm:p-8" tabindex="0">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-[#ff750f]/10 transition-transform duration-300 group-hover:scale-105">
                        <svg class="h-6 w-6 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#1a1a1a]">Armada Terawat</h3>
                    <p class="mt-2 flex-1 text-sm leading-relaxed text-[#555555]">
                        Bus berkualitas tinggi dengan inspeksi rutinitas berkala.
                    </p>
                    <div class="mt-4 inline-flex items-center gap-2 self-start rounded-full bg-emerald-50 px-3 py-1.5">
                        <svg class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-xs font-semibold text-emerald-700">Perawatan Berkala</span>
                    </div>
                </article>

                {{-- 4. Keamanan Terjamin — Row 2 Right, Highlighted Border --}}
                <article class="group flex flex-col overflow-hidden rounded-2xl border-2 border-amber-400 bg-[#faf9f8] p-6 transition-all duration-300 hover:-translate-y-0.5 hover:border-amber-500 hover:shadow-lg focus-within:ring-2 focus-within:ring-[#ff750f] sm:p-8" tabindex="0">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 transition-transform duration-300 group-hover:scale-105">
                        <svg class="h-6 w-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#1a1a1a]">Keamanan Terjamin</h3>
                    <p class="mt-2 flex-1 text-sm leading-relaxed text-[#555555]">
                        Pengemudi berpengalaman dan sistem pelacakan armada real-time.
                    </p>
                    <div class="mt-4 inline-flex items-center gap-2 self-start rounded-full bg-amber-50 px-3 py-1.5">
                        <svg class="h-4 w-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span class="text-xs font-semibold text-amber-700">Tersertifikasi</span>
                    </div>
                </article>

                {{-- 5. Rute Antarkota Terlengkap — Row 2 Right --}}
                <article class="group flex flex-col overflow-hidden rounded-2xl border border-[#e6e6e6] bg-[#faf9f8] p-6 transition-all duration-300 hover:-translate-y-0.5 hover:border-[#ff750f]/30 hover:shadow-lg focus-within:ring-2 focus-within:ring-[#ff750f] sm:p-8" tabindex="0">
                    <div class="flex flex-col gap-6 sm:flex-row sm:items-start">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#ff750f]/10 transition-transform duration-300 group-hover:scale-105">
                            <svg class="h-6 w-6 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-[#1a1a1a]">Rute Antarkota Terlengkap</h3>
                            <p class="mt-2 text-sm leading-relaxed text-[#555555]">
                                Menghubungkan Merak, Jakarta, Bandung, Semarang, Yogyakarta, Solo, Ngawi, Surabaya, Malang, dan Banyuwangi.
                            </p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-[#ff750f]/10 px-3 py-1 text-xs font-semibold text-[#ff750f]">
                                    <span class="h-1.5 w-1.5 rounded-full bg-[#ff750f]"></span>
                                    ANTIBU
                                </span>
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-[#1a1a1a]/5 px-3 py-1 text-xs font-semibold text-[#1a1a1a]">
                                    <span class="h-1.5 w-1.5 rounded-full bg-[#1a1a1a]"></span>
                                    SATSET
                                </span>
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-[#1a1a1a]/5 px-3 py-1 text-xs font-semibold text-[#1a1a1a]">
                                    <span class="h-1.5 w-1.5 rounded-full bg-[#1a1a1a]"></span>
                                    BIASANE
                                </span>
                            </div>
                        </div>
                    </div>
                </article>

            </div>
        </div>
    </section>

    {{-- Terkoneksi Bersama TransNgawi --}}
    <section class="bg-[#faf9f8] py-16 md:py-24">
        <div class="container-app">
            <div class="mb-12 max-w-2xl text-center md:text-left">
                <h2 class="text-3xl font-bold tracking-tight text-[#1a1a1a] sm:text-4xl">Terkoneksi Bersama TransNgawi</h2>
                <p class="mt-3 text-base text-[#555555]">Visualisasi rute berantai dimulai dari Hub Ngawi menuju kota-kota utama di seluruh Pulau Jawa.</p>
            </div>

            {{-- Map Container --}}
            <div class="relative w-full overflow-hidden rounded-xl bg-[#0a0a0a] shadow-2xl" style="aspect-ratio: 2/1">
                
                {{-- Java Island Dotted Silhouette Background --}}
                <svg class="pointer-events-none absolute inset-0 h-full w-full select-none opacity-40" viewBox="0 0 1000 450" preserveAspectRatio="xMidYMid meet">
                    <defs>
                        <pattern id="java-dot-matrix" x="0" y="0" width="6" height="6" patternUnits="userSpaceOnUse">
                            <circle cx="2" cy="2" r="1" fill="#ff750f" opacity="0.6"/>
                        </pattern>
                    </defs>
                    <path d="M 60,85 C 90,95 130,110 175,130 C 220,148 270,162 330,172 C 390,178 450,185 510,195 C 570,205 630,212 690,225 C 745,238 800,260 855,285 C 900,305 935,335 955,370 C 965,390 950,415 920,415 C 870,400 810,375 750,355 C 690,340 630,330 570,320 C 510,310 450,300 390,285 C 330,268 270,250 215,225 C 165,200 120,170 90,140 C 65,115 50,95 60,85 Z" fill="url(#java-dot-matrix)"/>
                </svg>

                {{-- Main Connectivity Layer --}}
                <svg viewBox="0 0 1000 450" class="pointer-events-auto relative h-full w-full select-none" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <filter id="glow-effect" x="-30%" y="-30%" width="160%" height="160%">
                            <feGaussianBlur stdDeviation="2.5" result="blur"/>
                            <feMerge>
                                <feMergeNode in="blur"/>
                                <feMergeNode in="SourceGraphic"/>
                            </feMerge>
                        </filter>
                        <style>
                            .line-draw {
                                stroke-dasharray: var(--len);
                                stroke-dashoffset: var(--len);
                                animation: drawLine 0.4s ease-out var(--delay) forwards;
                            }
                            .node-dot, .node-dot-hub {
                                opacity: 0;
                                animation: nodeAppear 0.3s ease-out var(--delay) forwards;
                            }
                            .node-ring, .node-ring-hub {
                                opacity: 0;
                            }
                            .node-ring { animation: ringPulse 2.5s ease-in-out var(--delay) infinite; }
                            .node-ring-hub { animation: ringPulseHub 2.5s ease-in-out var(--delay) infinite; }
                            .node-label {
                                opacity: 0;
                                animation: labelAppear 0.4s ease-out var(--delay) forwards;
                            }
                            @keyframes drawLine {
                                to { stroke-dashoffset: 0; }
                            }
                            @keyframes nodeAppear {
                                to { opacity: 1; }
                            }
                            @keyframes ringPulse {
                                0% { opacity: 0; r: 7; }
                                10% { opacity: 0.8; }
                                50% { opacity: 0.2; r: 12.6; }
                                100% { opacity: 0.8; r: 7; }
                            }
                            @keyframes ringPulseHub {
                                0% { opacity: 0.8; r: 7; }
                                50% { opacity: 0.2; r: 12.6; }
                                100% { opacity: 0.8; r: 7; }
                            }
                            @keyframes labelAppear {
                                from { opacity: 0; transform: translateY(6px); }
                                to { opacity: 1; transform: translateY(0); }
                            }
                            @media (prefers-reduced-motion: reduce) {
                                .line-draw, .node-dot, .node-dot-hub,
                                .node-ring, .node-ring-hub, .node-label {
                                    animation: none !important;
                                    opacity: 1 !important;
                                    stroke-dashoffset: 0 !important;
                                }
                            }
                        </style>
                    </defs>

                    {{-- Connector Lines --}}
                    <g fill="none" stroke="#F97316" stroke-width="2" stroke-linecap="round" opacity="0.8">

                        {{-- Wave 1: Ngawi → Solo --}}
                        <path class="line-draw" style="--len:81;--delay:0.4s" d="M 625 265 L 550 275"/>
                        {{-- Wave 1: Ngawi → Surabaya --}}
                        <path class="line-draw" style="--len:123;--delay:0.4s" d="M 625 265 L 745 205"/>

                        {{-- Wave 2: Solo → Yogyakarta --}}
                        <path class="line-draw" style="--len:82;--delay:0.8s" d="M 550 275 L 490 315"/>
                        {{-- Wave 2: Solo → Semarang --}}
                        <path class="line-draw" style="--len:73;--delay:0.8s" d="M 550 275 L 500 215"/>
                        {{-- Wave 2: Surabaya → Semarang --}}
                        <path class="line-draw" style="--len:245;--delay:0.8s" d="M 745 205 L 500 215"/>
                        {{-- Wave 2: Surabaya → Malang --}}
                        <path class="line-draw" style="--len:100;--delay:0.8s" d="M 745 205 L 735 305"/>
                        {{-- Wave 2: Surabaya → Banyuwangi --}}
                        <path class="line-draw" style="--len:150;--delay:0.8s" d="M 745 205 L 875 335"/>

                        {{-- Wave 3: Yogyakarta → Bandung --}}
                        <path class="line-draw" style="--len:268;--delay:1.2s" d="M 490 315 L 285 220"/>
                        {{-- Wave 3: Semarang → Bandung --}}
                        <path class="line-draw" style="--len:216;--delay:1.2s" d="M 500 215 L 285 220"/>

                        {{-- Wave 4: Bandung → Jakarta --}}
                        <path class="line-draw" style="--len:96;--delay:1.6s" d="M 285 220 L 215 145"/>
                        {{-- Wave 4: Semarang → Jakarta --}}
                        <path class="line-draw" style="--len:286;--delay:1.6s" d="M 500 215 L 215 145"/>

                        {{-- Wave 5: Jakarta → Merak --}}
                        <path class="line-draw" style="--len:76;--delay:2.0s" d="M 215 145 L 140 115"/>
                    </g>

                    {{-- City Nodes & Labels --}}
                    <g>
                        {{-- Wave 0: Ngawi (Hub) --}}
                        <g>
                            <circle class="node-ring-hub" cx="625" cy="265" r="7" fill="none" stroke="#ff750f" stroke-width="1" style="--delay:0s"/>
                            <circle class="node-dot-hub" cx="625" cy="265" r="4.5" fill="#ff750f" filter="url(#glow-effect)" style="--delay:0s"/>
                        </g>
                        <foreignObject class="node-label" x="575" y="231" width="100" height="30" style="--delay:0.1s">
                            <div class="flex items-center justify-center h-full">
                                <span class="whitespace-nowrap rounded-md border border-[#ff750f]/60 bg-[#ff750f]/90 px-2.5 py-0.5 text-xs font-semibold text-white shadow-lg shadow-[#ff750f]/30 ring-1 ring-[#ff750f]/30 backdrop-blur-md">Ngawi (Hub)</span>
                            </div>
                        </foreignObject>

                        {{-- Wave 1: Solo --}}
                        <g>
                            <circle class="node-ring" cx="550" cy="275" r="7" fill="none" stroke="#FBBF24" stroke-width="1" style="--delay:0.4s"/>
                            <circle class="node-dot" cx="550" cy="275" r="3.5" fill="#FBBF24" filter="url(#glow-effect)" style="--delay:0.4s"/>
                        </g>
                        <foreignObject class="node-label" x="500" y="241" width="100" height="30" style="--delay:0.5s">
                            <div class="flex items-center justify-center h-full">
                                <span class="whitespace-nowrap rounded-md border border-[#0a0a0a]/80 bg-[#0a0a0a]/90 px-2.5 py-0.5 text-xs font-semibold text-white shadow-lg backdrop-blur-md">Solo</span>
                            </div>
                        </foreignObject>

                        {{-- Wave 1: Surabaya --}}
                        <g>
                            <circle class="node-ring" cx="745" cy="205" r="7" fill="none" stroke="#FBBF24" stroke-width="1" style="--delay:0.4s"/>
                            <circle class="node-dot" cx="745" cy="205" r="3.5" fill="#FBBF24" filter="url(#glow-effect)" style="--delay:0.4s"/>
                        </g>
                        <foreignObject class="node-label" x="695" y="171" width="100" height="30" style="--delay:0.5s">
                            <div class="flex items-center justify-center h-full">
                                <span class="whitespace-nowrap rounded-md border border-[#0a0a0a]/80 bg-[#0a0a0a]/90 px-2.5 py-0.5 text-xs font-semibold text-white shadow-lg backdrop-blur-md">Surabaya</span>
                            </div>
                        </foreignObject>

                        {{-- Wave 2: Yogyakarta --}}
                        <g>
                            <circle class="node-ring" cx="490" cy="315" r="7" fill="none" stroke="#FBBF24" stroke-width="1" style="--delay:0.8s"/>
                            <circle class="node-dot" cx="490" cy="315" r="3.5" fill="#FBBF24" filter="url(#glow-effect)" style="--delay:0.8s"/>
                        </g>
                        <foreignObject class="node-label" x="440" y="281" width="100" height="30" style="--delay:0.9s">
                            <div class="flex items-center justify-center h-full">
                                <span class="whitespace-nowrap rounded-md border border-[#0a0a0a]/80 bg-[#0a0a0a]/90 px-2.5 py-0.5 text-xs font-semibold text-white shadow-lg backdrop-blur-md">Yogyakarta</span>
                            </div>
                        </foreignObject>

                        {{-- Wave 2: Semarang --}}
                        <g>
                            <circle class="node-ring" cx="500" cy="215" r="7" fill="none" stroke="#FBBF24" stroke-width="1" style="--delay:0.8s"/>
                            <circle class="node-dot" cx="500" cy="215" r="3.5" fill="#FBBF24" filter="url(#glow-effect)" style="--delay:0.8s"/>
                        </g>
                        <foreignObject class="node-label" x="450" y="181" width="100" height="30" style="--delay:0.9s">
                            <div class="flex items-center justify-center h-full">
                                <span class="whitespace-nowrap rounded-md border border-[#0a0a0a]/80 bg-[#0a0a0a]/90 px-2.5 py-0.5 text-xs font-semibold text-white shadow-lg backdrop-blur-md">Semarang</span>
                            </div>
                        </foreignObject>

                        {{-- Wave 2: Malang --}}
                        <g>
                            <circle class="node-ring" cx="735" cy="305" r="7" fill="none" stroke="#FBBF24" stroke-width="1" style="--delay:0.8s"/>
                            <circle class="node-dot" cx="735" cy="305" r="3.5" fill="#FBBF24" filter="url(#glow-effect)" style="--delay:0.8s"/>
                        </g>
                        <foreignObject class="node-label" x="685" y="271" width="100" height="30" style="--delay:0.9s">
                            <div class="flex items-center justify-center h-full">
                                <span class="whitespace-nowrap rounded-md border border-[#0a0a0a]/80 bg-[#0a0a0a]/90 px-2.5 py-0.5 text-xs font-semibold text-white shadow-lg backdrop-blur-md">Malang</span>
                            </div>
                        </foreignObject>

                        {{-- Wave 2: Banyuwangi --}}
                        <g>
                            <circle class="node-ring" cx="875" cy="335" r="7" fill="none" stroke="#FBBF24" stroke-width="1" style="--delay:0.8s"/>
                            <circle class="node-dot" cx="875" cy="335" r="3.5" fill="#FBBF24" filter="url(#glow-effect)" style="--delay:0.8s"/>
                        </g>
                        <foreignObject class="node-label" x="825" y="301" width="100" height="30" style="--delay:0.9s">
                            <div class="flex items-center justify-center h-full">
                                <span class="whitespace-nowrap rounded-md border border-[#0a0a0a]/80 bg-[#0a0a0a]/90 px-2.5 py-0.5 text-xs font-semibold text-white shadow-lg backdrop-blur-md">Banyuwangi</span>
                            </div>
                        </foreignObject>

                        {{-- Wave 3: Bandung --}}
                        <g>
                            <circle class="node-ring" cx="285" cy="220" r="7" fill="none" stroke="#FBBF24" stroke-width="1" style="--delay:1.2s"/>
                            <circle class="node-dot" cx="285" cy="220" r="3.5" fill="#FBBF24" filter="url(#glow-effect)" style="--delay:1.2s"/>
                        </g>
                        <foreignObject class="node-label" x="235" y="186" width="100" height="30" style="--delay:1.3s">
                            <div class="flex items-center justify-center h-full">
                                <span class="whitespace-nowrap rounded-md border border-[#0a0a0a]/80 bg-[#0a0a0a]/90 px-2.5 py-0.5 text-xs font-semibold text-white shadow-lg backdrop-blur-md">Bandung</span>
                            </div>
                        </foreignObject>

                        {{-- Wave 4: Jakarta --}}
                        <g>
                            <circle class="node-ring" cx="215" cy="145" r="7" fill="none" stroke="#FBBF24" stroke-width="1" style="--delay:1.6s"/>
                            <circle class="node-dot" cx="215" cy="145" r="3.5" fill="#FBBF24" filter="url(#glow-effect)" style="--delay:1.6s"/>
                        </g>
                        <foreignObject class="node-label" x="165" y="111" width="100" height="30" style="--delay:1.7s">
                            <div class="flex items-center justify-center h-full">
                                <span class="whitespace-nowrap rounded-md border border-[#0a0a0a]/80 bg-[#0a0a0a]/90 px-2.5 py-0.5 text-xs font-semibold text-white shadow-lg backdrop-blur-md">Jakarta</span>
                            </div>
                        </foreignObject>

                        {{-- Wave 5: Merak --}}
                        <g>
                            <circle class="node-ring" cx="140" cy="115" r="7" fill="none" stroke="#FBBF24" stroke-width="1" style="--delay:2.0s"/>
                            <circle class="node-dot" cx="140" cy="115" r="3.5" fill="#FBBF24" filter="url(#glow-effect)" style="--delay:2.0s"/>
                        </g>
                        <foreignObject class="node-label" x="90" y="81" width="100" height="30" style="--delay:2.1s">
                            <div class="flex items-center justify-center h-full">
                                <span class="whitespace-nowrap rounded-md border border-[#0a0a0a]/80 bg-[#0a0a0a]/90 px-2.5 py-0.5 text-xs font-semibold text-white shadow-lg backdrop-blur-md">Merak</span>
                            </div>
                        </foreignObject>
                    </g>
                </svg>
            </div>

            {{-- Legend --}}
            <div class="mt-6 flex flex-wrap items-center justify-center gap-6 text-sm text-[#555555]">
                <div class="flex items-center gap-2">
                    <div class="h-3 w-3 rounded-full bg-[#F97316] shadow-lg shadow-[#F97316]/30"></div>
                    <p>Hub Utama (Ngawi)</p>
                </div>
                <div class="flex items-center gap-2">
                    <div class="h-3 w-3 rounded-full bg-[#FBBF24]"></div>
                    <p>Kota Tujuan</p>
                </div>
                <div class="flex items-center gap-2">
                    <div class="h-3 w-3 rounded-full border-2 border-white bg-[#0a0a0a]"></div>
                    <p>Titik Bergerak</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Cerita Kami --}}
    <section class="bg-[#faf9f8] py-16 md:py-24">
        <div class="container-app">
            <div class="mb-12 max-w-2xl">
                <h2 class="text-3xl font-bold tracking-tight text-[#1a1a1a] sm:text-4xl">Cerita Kami</h2>
                <p class="mt-3 text-base text-[#555555]">Perjalanan kami dimulai dari satu keyakinan sederhana.</p>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-5">

                {{-- Founder Card — Mobile: first, Desktop: right column --}}
                <div class="order-1 flex flex-col lg:order-2 lg:col-span-2">
                    <div class="card flex flex-1 flex-col overflow-hidden">
                        <div class="relative min-h-[280px] flex-1 bg-[#e6e6e6] sm:min-h-[320px] lg:min-h-0">
                            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/masamba.jpg') }}')"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0a0a0a]/80 via-transparent to-transparent"></div>
                        </div>
                        <div class="p-6 sm:p-8">
                            <h3 class="text-xl font-bold text-[#1a1a1a]">Mas Amba S.T</h3>
                            <p class="mt-1 text-sm font-medium text-[#ff750f]">Founder & CEO TransNgawi</p>
                            <p class="mt-3 text-sm leading-relaxed text-[#555555]">
                                Insinyur teknik transportasi lulusan ITS Surabaya. Sejak kuliah aktif meneliti pola mobilitas antarkota di Jawa. Pengalaman 10+ tahun di industri transportasi nasional sebelum membangun TransNgawi.
                            </p>
                            <blockquote class="mt-5 border-l-2 border-[#ff750f] pl-4">
                                <p class="text-sm italic leading-relaxed text-[#1a1a1a]">"Saya melihat banyak anak muda yang frustasi dengan transportasi antarkota. Mereka ingin sesuatu yang lebih baik, tapi harganya tidak ramah di kantong. TransNgawi ada untuk mengisi celah itu."</p>
                            </blockquote>
                        </div>
                    </div>
                </div>

                {{-- Timeline — Mobile: second, Desktop: left column --}}
                <div class="order-2 flex flex-col lg:order-1 lg:col-span-3">
                    <div class="card flex flex-1 flex-col p-6 sm:p-8 lg:p-10">
                        <h3 class="text-2xl font-bold text-[#1a1a1a]">Perjalanan TransNgawi</h3>
                        <p class="mt-2 text-sm text-[#555555]">Dari satu visi sederhana menjadi jaringan perjalanan antarkota.</p>

                        <div class="mt-8 space-y-0">

                            {{-- Milestone 1 --}}
                            <div class="relative flex gap-4 pb-8">
                                <div class="flex flex-col items-center">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#ff750f] text-xs font-bold text-white shadow-lg shadow-[#ff750f]/30">1</div>
                                    <div class="mt-2 h-full w-0.5 bg-[#e6e6e6]"></div>
                                </div>
                                <div class="pt-1.5">
                                    <p class="text-xs font-bold uppercase tracking-widest text-[#ff750f]">2024</p>
                                    <h4 class="mt-1 text-base font-bold text-[#1a1a1a]">Berdiri di Ngawi</h4>
                                    <p class="mt-1.5 text-sm leading-relaxed text-[#555555]">Mas Amba memulai TransNgawi dari kota kelahirannya. Rute pertama: Ngawi – Surabaya. Satu bus, satu visi — transportasi antarkota yang jujur dan terjangkau.</p>
                                </div>
                            </div>

                            {{-- Milestone 2 --}}
                            <div class="relative flex gap-4 pb-8">
                                <div class="flex flex-col items-center">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#ff750f] text-xs font-bold text-white shadow-lg shadow-[#ff750f]/30">2</div>
                                    <div class="mt-2 h-full w-0.5 bg-[#e6e6e6]"></div>
                                </div>
                                <div class="pt-1.5">
                                    <p class="text-xs font-bold uppercase tracking-widest text-[#ff750f]">2024</p>
                                    <h4 class="mt-1 text-base font-bold text-[#1a1a1a]">Tiga Kelas, Satu Standar</h4>
                                    <p class="mt-1.5 text-sm leading-relaxed text-[#555555]">Memperkenalkan Sukian, SukianPlus, dan SukianPro — tiga kelas layanan yang memberikan fleksibilitas tanpa mengorbankan kenyamanan. Setiap orang berhak mendapatkan perjalanan yang baik.</p>
                                </div>
                            </div>

                            {{-- Milestone 3 --}}
                            <div class="relative flex gap-4 pb-8">
                                <div class="flex flex-col items-center">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#ff750f] text-xs font-bold text-white shadow-lg shadow-[#ff750f]/30">3</div>
                                    <div class="mt-2 h-full w-0.5 bg-[#e6e6e6]"></div>
                                </div>
                                <div class="pt-1.5">
                                    <p class="text-xs font-bold uppercase tracking-widest text-[#ff750f]">2025</p>
                                    <h4 class="mt-1 text-base font-bold text-[#1a1a1a]">Booking Digital, Tanpa Antrian</h4>
                                    <p class="mt-1.5 text-sm leading-relaxed text-[#555555]">Meluncurkan platform pemesanan online. Pelanggan bisa memilih kelas, tempat duduk, dan membayar dalam hitungan menit. Proses yang seharusnya sederhana.</p>
                                </div>
                            </div>

                            {{-- Milestone 4 --}}
                            <div class="relative flex gap-4">
                                <div class="flex flex-col items-center">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#ff750f] text-xs font-bold text-white shadow-lg shadow-[#ff750f]/30">4</div>
                                </div>
                                <div class="pt-1.5">
                                    <p class="text-xs font-bold uppercase tracking-widest text-[#ff750f]">Sekarang</p>
                                    <h4 class="mt-1 text-base font-bold text-[#1a1a1a]">Menghubungkan Jawa</h4>
                                    <p class="mt-1.5 text-sm leading-relaxed text-[#555555]">Dari Ngawi ke Surabaya, Semarang, Yogyakarta, Bandung, Jakarta, hingga Banyuwangi. TransNgawi terus bertumbuh — karena perjalanan yang baik harus bisa diakses oleh semua orang.</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
