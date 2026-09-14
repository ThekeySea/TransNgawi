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

    {{-- Keunggulan Kami --}}
    <section class="bg-white py-16 md:py-24">
        <div class="container-app">
            <div class="mb-12 max-w-2xl">
                <h2 class="text-3xl font-bold tracking-tight text-[#1a1a1a] sm:text-4xl">Keunggulan Kami</h2>
                <p class="mt-3 text-base text-[#555555]">Alasan memilih TransNgawi untuk perjalananmu.</p>
            </div>

            {{-- Bento Grid: 5 items --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3">

                {{-- 1. Harga Termurah (large) --}}
                <div class="card row-span-2 flex flex-col justify-between overflow-hidden p-6 sm:p-8 lg:row-span-2">
                    <div>
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-[#ff750f]/10">
                            <svg class="h-6 w-6 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-[#1a1a1a]">Harga Paling Masuk Akal</h3>
                        <p class="mt-3 text-sm leading-relaxed text-[#555555]">
                            Bukan sekadar murah, kami menawarkan value terbaik di kelasnya. Dibandingkan kompetitor sejenis, TransNgawi memberikan harga yang lebih rendah dengan kenyamanan yang lebih tinggi.
                        </p>
                    </div>
                    <div class="mt-6 rounded-xl bg-[#faf9f8] p-4">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl font-bold text-[#ff750f]">Rp195K</span>
                            <span class="text-xs text-[#666666]">mulai dari<br>Sukian</span>
                        </div>
                        <p class="mt-2 text-xs text-[#999999]">*Harga paling rendah di kelasnya</p>
                    </div>
                </div>

                {{-- 2. Booking Instan --}}
                <div class="card flex flex-col p-6 sm:p-8">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-[#ff750f]/10">
                        <svg class="h-6 w-6 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#1a1a1a]">Booking Instan</h3>
                    <p class="mt-2 text-sm text-[#555555]">Pesan tiket dalam hitungan menit, tanpa antrian.</p>
                </div>

                {{-- 3. Keamanan Terjamin --}}
                <div class="card flex flex-col p-6 sm:p-8">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-[#ff750f]/10">
                        <svg class="h-6 w-6 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#1a1a1a]">Keamanan Terjamin</h3>
                    <p class="mt-2 text-sm text-[#555555]">Armada terawat dan driver berpengalaman.</p>
                </div>

                {{-- 4. Armada Modern --}}
                <div class="card flex flex-col p-6 sm:p-8">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-[#ff750f]/10">
                        <svg class="h-6 w-6 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#1a1a1a]">Armada Terawat</h3>
                    <p class="mt-2 text-sm text-[#555555]">Bus berkualitas tinggi dengan perawatan berkala.</p>
                </div>

                {{-- 5. Rute Lengkap (wide) --}}
                <div class="card col-span-1 flex flex-col p-6 sm:p-8 sm:col-span-2 lg:col-span-2">
                    <div class="flex flex-col gap-6 sm:flex-row sm:items-center">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#ff750f]/10">
                            <svg class="h-6 w-6 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-[#1a1a1a]">Rute Antarkota Terlengkap</h3>
                            <p class="mt-1 text-sm text-[#555555]">Menghubungkan Surabaya, Semarang, Yogyakarta, Bandung, Jakarta, dan kota besar lainnya.</p>
                        </div>
                        <div class="flex flex-wrap gap-2 sm:ml-auto">
                            <span class="rounded-full bg-[#1a1a1a]/5 px-3 py-1 text-xs font-medium text-[#1a1a1a]">ANTIBU</span>
                            <span class="rounded-full bg-[#1a1a1a]/5 px-3 py-1 text-xs font-medium text-[#1a1a1a]">SATSET</span>
                            <span class="rounded-full bg-[#1a1a1a]/5 px-3 py-1 text-xs font-medium text-[#1a1a1a]">BIASANE</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Terkoneksi Bersama TransNgawi --}}
    <section class="bg-white py-16 md:py-24">
        <div class="container-app">
            <div class="mb-12 max-w-2xl text-center md:text-left">
                <h2 class="text-3xl font-bold tracking-tight text-[#1a1a1a] sm:text-4xl">Terkoneksi Bersama TransNgawi</h2>
                <p class="mt-3 text-base text-[#555555]">Visualisasi rute berantai dimulai dari Hub Ngawi menuju kota-kota utama di seluruh Pulau Jawa.</p>
            </div>

            {{-- Map Container --}}
            <div class="relative w-full overflow-hidden rounded-xl bg-[#0a0a0a] shadow-2xl" style="aspect-ratio: 2/1">
                
                {{-- Java Island Dotted Silhouette Background --}}
                <svg class="pointer-events-none absolute inset-0 h-full w-full select-none opacity-40" viewBox="0 0 800 400" preserveAspectRatio="xMidYMid meet">
                    <defs>
                        <pattern id="java-dot-matrix" x="0" y="0" width="6" height="6" patternUnits="userSpaceOnUse">
                            <circle cx="2" cy="2" r="1" fill="#ff750f" opacity="0.6"/>
                        </pattern>
                    </defs>
                    {{-- Geographically Calibrated Vector Outline of Java Island --}}
                    <path d="M 70,50 C 100,55 140,75 180,95 C 220,115 260,125 310,135 C 360,140 420,150 480,165 C 540,175 600,180 660,195 C 710,210 750,230 765,260 C 770,290 750,310 720,310 C 660,295 610,270 560,260 C 500,250 440,255 380,245 C 320,235 260,220 200,190 C 150,165 110,140 75,115 C 50,90 55,65 70,50 Z" fill="url(#java-dot-matrix)"/>
                </svg>

                {{-- Main Interactive Connectivity Layer --}}
                <svg viewBox="0 0 800 400" class="pointer-events-auto relative h-full w-full select-none" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        {{-- Gradient for route lines --}}
                        <linearGradient id="orange-gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="#ff750f" stop-opacity="0.3"/>
                            <stop offset="50%" stop-color="#ff750f" stop-opacity="0.8"/>
                            <stop offset="100%" stop-color="#ffaa00" stop-opacity="1"/>
                        </linearGradient>
                        
                        {{-- Glow filter --}}
                        <filter id="glow-effect" x="-30%" y="-30%" width="160%" height="160%">
                            <feGaussianBlur stdDeviation="2.5" result="blur"/>
                            <feMerge>
                                <feMergeNode in="blur"/>
                                <feMergeNode in="SourceGraphic"/>
                            </feMerge>
                        </filter>

                        {{-- Animation styles --}}
                        <style>
                            .travel-dot {
                                offset-rotate: 0deg;
                            }
                            @keyframes pulseRing {
                                0% { transform: scale(1); opacity: 0.8; }
                                50% { transform: scale(1.8); opacity: 0.2; }
                                100% { transform: scale(1); opacity: 0.8; }
                            }
                            @keyframes labelAppear {
                                from { opacity: 0; transform: translateY(6px); }
                                to { opacity: 1; transform: translateY(0); }
                            }
                        </style>
                    </defs>

                    {{-- 1. Curved Connecting Path Lines --}}
                    <g fill="none" stroke="url(#orange-gradient)" stroke-width="1.8" stroke-linecap="round">
                        
                        {{-- === CABANG 1 (Barat): Ngawi → Solo → Jogja → Bandung → Jakarta === --}}
                        
                        {{-- Ngawi → Solo (Sequence 0) --}}
                        <path id="route-0" d="M 516 218 Q 491 227 466 236" stroke-dasharray="1000" stroke-dashoffset="1000">
                            <animate attributeName="stroke-dashoffset" from="1000" to="0" dur="1.2s" begin="0s" fill="freeze"/>
                        </path>
                        <circle r="3.5" fill="#ffffff" filter="url(#glow-effect)" class="travel-dot" style="offset-path: path('M 516 218 Q 491 227 466 236'); animation: travelDot 1.2s ease-in-out 0s forwards;"/>
                        
                        {{-- Solo → Yogyakarta (Sequence 1) --}}
                        <path id="route-1" d="M 466 236 Q 448 249 430 262" stroke-dasharray="1000" stroke-dashoffset="1000">
                            <animate attributeName="stroke-dashoffset" from="1000" to="0" dur="1.2s" begin="1.2s" fill="freeze"/>
                        </path>
                        <circle r="3.5" fill="#ffffff" filter="url(#glow-effect)" class="travel-dot" style="offset-path: path('M 466 236 Q 448 249 430 262'); animation: travelDot 1.2s ease-in-out 1.2s forwards;"/>
                        
                        {{-- Yogyakarta → Bandung (Sequence 2) --}}
                        <path id="route-2" d="M 430 262 Q 320 211 210 161" stroke-dasharray="1000" stroke-dashoffset="1000">
                            <animate attributeName="stroke-dashoffset" from="1000" to="0" dur="1.2s" begin="2.4s" fill="freeze"/>
                        </path>
                        <circle r="3.5" fill="#ffffff" filter="url(#glow-effect)" class="travel-dot" style="offset-path: path('M 430 262 Q 320 211 210 161'); animation: travelDot 1.2s ease-in-out 2.4s forwards;"/>
                        
                        {{-- Bandung → Jakarta (Sequence 3) --}}
                        <path id="route-3" d="M 210 161 Q 178 119 146 77" stroke-dasharray="1000" stroke-dashoffset="1000">
                            <animate attributeName="stroke-dashoffset" from="1000" to="0" dur="1.2s" begin="3.6s" fill="freeze"/>
                        </path>
                        <circle r="3.5" fill="#ffffff" filter="url(#glow-effect)" class="travel-dot" style="offset-path: path('M 210 161 Q 178 119 146 77'); animation: travelDot 1.2s ease-in-out 3.6s forwards;"/>
                        
                        {{-- === CABANG 2 (Timur & Utara): Ngawi → Surabaya → Semarang === --}}
                        
                        {{-- Ngawi → Surabaya (Sequence 0) --}}
                        <path id="route-4" d="M 516 218 Q 568 210 620 201" stroke-dasharray="1000" stroke-dashoffset="1000">
                            <animate attributeName="stroke-dashoffset" from="1000" to="0" dur="1.2s" begin="0s" fill="freeze"/>
                        </path>
                        <circle r="3.5" fill="#ffffff" filter="url(#glow-effect)" class="travel-dot" style="offset-path: path('M 516 218 Q 568 210 620 201'); animation: travelDot 1.2s ease-in-out 0s forwards;"/>
                        
                        {{-- Surabaya → Semarang (Sequence 1) --}}
                        <path id="route-5" d="M 620 201 Q 527 185 433 168" stroke-dasharray="1000" stroke-dashoffset="1000">
                            <animate attributeName="stroke-dashoffset" from="1000" to="0" dur="1.2s" begin="1.2s" fill="freeze"/>
                        </path>
                        <circle r="3.5" fill="#ffffff" filter="url(#glow-effect)" class="travel-dot" style="offset-path: path('M 620 201 Q 527 185 433 168'); animation: travelDot 1.2s ease-in-out 1.2s forwards;"/>
                        
                        {{-- === CABANG 3 (Timur & Selatan): Surabaya → Malang & Banyuwangi === --}}
                        
                        {{-- Surabaya → Malang (Sequence 2) --}}
                        <path id="route-6" d="M 620 201 Q 615 242 610 284" stroke-dasharray="1000" stroke-dashoffset="1000">
                            <animate attributeName="stroke-dashoffset" from="1000" to="0" dur="1.2s" begin="2.4s" fill="freeze"/>
                        </path>
                        <circle r="3.5" fill="#ffffff" filter="url(#glow-effect)" class="travel-dot" style="offset-path: path('M 620 201 Q 615 242 610 284'); animation: travelDot 1.2s ease-in-out 2.4s forwards;"/>
                        
                        {{-- Surabaya → Banyuwangi (Sequence 2) --}}
                        <path id="route-7" d="M 620 201 Q 685 256 750 311" stroke-dasharray="1000" stroke-dashoffset="1000">
                            <animate attributeName="stroke-dashoffset" from="1000" to="0" dur="1.2s" begin="2.4s" fill="freeze"/>
                        </path>
                        <circle r="3.5" fill="#ffffff" filter="url(#glow-effect)" class="travel-dot" style="offset-path: path('M 620 201 Q 685 256 750 311'); animation: travelDot 1.2s ease-in-out 2.4s forwards;"/>
                    </g>

                    {{-- 2. City Node Points & Floating Pill Labels --}}
                    <g>
                        {{-- Ngawi (Hub - Starting Point) --}}
                        <g>
                            {{-- Outer Pulse Effect --}}
                            <circle cx="516" cy="218" r="7" fill="none" stroke="#ff750f" stroke-width="1">
                                <animate attributeName="r" values="7;12.6;7" dur="2.5s" begin="0s" repeatCount="indefinite"/>
                                <animate attributeName="opacity" values="0.8;0.2;0.8" dur="2.5s" begin="0s" repeatCount="indefinite"/>
                            </circle>
                            {{-- Solid Glowing City Center Dot --}}
                            <circle cx="516" cy="218" r="4.5" fill="#ff750f" filter="url(#glow-effect)"/>
                        </g>
                        {{-- Floating City Pill Label Badge --}}
                        <foreignObject x="466" y="184" width="100" height="30" class="block overflow-visible">
                            <div class="flex items-center justify-center h-full">
                                <span class="whitespace-nowrap rounded-md border border-[#ff750f]/60 bg-[#ff750f]/90 px-2.5 py-0.5 text-xs font-semibold text-white shadow-lg shadow-[#ff750f]/30 ring-1 ring-[#ff750f]/30 backdrop-blur-md">Ngawi (Hub)</span>
                            </div>
                        </foreignObject>

                        {{-- Solo (Arrival: 1.2s) --}}
                        <g>
                            <circle cx="466" cy="236" r="7" fill="none" stroke="#ffaa00" stroke-width="1" opacity="0">
                                <animate attributeName="r" values="7;12.6;7" dur="2.5s" begin="1.2s" repeatCount="indefinite"/>
                                <animate attributeName="opacity" values="0;0.8;0.2;0.8" dur="2.5s" begin="1.2s" repeatCount="indefinite"/>
                            </circle>
                            <circle cx="466" cy="236" r="3.5" fill="#ffaa00" filter="url(#glow-effect)" opacity="0">
                                <animate attributeName="opacity" from="0" to="1" dur="0.3s" begin="1.2s" fill="freeze"/>
                            </circle>
                        </g>
                        <foreignObject x="416" y="202" width="100" height="30" class="block overflow-visible" style="opacity: 0; animation: labelAppear 0.4s ease-out 1.3s forwards;">
                            <div class="flex items-center justify-center h-full">
                                <span class="whitespace-nowrap rounded-md border border-[#0a0a0a]/80 bg-[#0a0a0a]/90 px-2.5 py-0.5 text-xs font-semibold text-white shadow-lg backdrop-blur-md">Solo</span>
                            </div>
                        </foreignObject>

                        {{-- Yogyakarta (Arrival: 2.4s) --}}
                        <g>
                            <circle cx="430" cy="262" r="7" fill="none" stroke="#ffaa00" stroke-width="1" opacity="0">
                                <animate attributeName="r" values="7;12.6;7" dur="2.5s" begin="2.4s" repeatCount="indefinite"/>
                                <animate attributeName="opacity" values="0;0.8;0.2;0.8" dur="2.5s" begin="2.4s" repeatCount="indefinite"/>
                            </circle>
                            <circle cx="430" cy="262" r="3.5" fill="#ffaa00" filter="url(#glow-effect)" opacity="0">
                                <animate attributeName="opacity" from="0" to="1" dur="0.3s" begin="2.4s" fill="freeze"/>
                            </circle>
                        </g>
                        <foreignObject x="380" y="228" width="100" height="30" class="block overflow-visible" style="opacity: 0; animation: labelAppear 0.4s ease-out 2.5s forwards;">
                            <div class="flex items-center justify-center h-full">
                                <span class="whitespace-nowrap rounded-md border border-[#0a0a0a]/80 bg-[#0a0a0a]/90 px-2.5 py-0.5 text-xs font-semibold text-white shadow-lg backdrop-blur-md">Yogyakarta</span>
                            </div>
                        </foreignObject>

                        {{-- Bandung (Arrival: 3.6s) --}}
                        <g>
                            <circle cx="210" cy="161" r="7" fill="none" stroke="#ffaa00" stroke-width="1" opacity="0">
                                <animate attributeName="r" values="7;12.6;7" dur="2.5s" begin="3.6s" repeatCount="indefinite"/>
                                <animate attributeName="opacity" values="0;0.8;0.2;0.8" dur="2.5s" begin="3.6s" repeatCount="indefinite"/>
                            </circle>
                            <circle cx="210" cy="161" r="3.5" fill="#ffaa00" filter="url(#glow-effect)" opacity="0">
                                <animate attributeName="opacity" from="0" to="1" dur="0.3s" begin="3.6s" fill="freeze"/>
                            </circle>
                        </g>
                        <foreignObject x="160" y="127" width="100" height="30" class="block overflow-visible" style="opacity: 0; animation: labelAppear 0.4s ease-out 3.7s forwards;">
                            <div class="flex items-center justify-center h-full">
                                <span class="whitespace-nowrap rounded-md border border-[#0a0a0a]/80 bg-[#0a0a0a]/90 px-2.5 py-0.5 text-xs font-semibold text-white shadow-lg backdrop-blur-md">Bandung</span>
                            </div>
                        </foreignObject>

                        {{-- Jakarta (Arrival: 4.8s) --}}
                        <g>
                            <circle cx="146" cy="77" r="7" fill="none" stroke="#ffaa00" stroke-width="1" opacity="0">
                                <animate attributeName="r" values="7;12.6;7" dur="2.5s" begin="4.8s" repeatCount="indefinite"/>
                                <animate attributeName="opacity" values="0;0.8;0.2;0.8" dur="2.5s" begin="4.8s" repeatCount="indefinite"/>
                            </circle>
                            <circle cx="146" cy="77" r="3.5" fill="#ffaa00" filter="url(#glow-effect)" opacity="0">
                                <animate attributeName="opacity" from="0" to="1" dur="0.3s" begin="4.8s" fill="freeze"/>
                            </circle>
                        </g>
                        <foreignObject x="96" y="43" width="100" height="30" class="block overflow-visible" style="opacity: 0; animation: labelAppear 0.4s ease-out 4.9s forwards;">
                            <div class="flex items-center justify-center h-full">
                                <span class="whitespace-nowrap rounded-md border border-[#0a0a0a]/80 bg-[#0a0a0a]/90 px-2.5 py-0.5 text-xs font-semibold text-white shadow-lg backdrop-blur-md">Jakarta</span>
                            </div>
                        </foreignObject>

                        {{-- Surabaya (Arrival: 1.2s) --}}
                        <g>
                            <circle cx="620" cy="201" r="7" fill="none" stroke="#ffaa00" stroke-width="1" opacity="0">
                                <animate attributeName="r" values="7;12.6;7" dur="2.5s" begin="1.2s" repeatCount="indefinite"/>
                                <animate attributeName="opacity" values="0;0.8;0.2;0.8" dur="2.5s" begin="1.2s" repeatCount="indefinite"/>
                            </circle>
                            <circle cx="620" cy="201" r="3.5" fill="#ffaa00" filter="url(#glow-effect)" opacity="0">
                                <animate attributeName="opacity" from="0" to="1" dur="0.3s" begin="1.2s" fill="freeze"/>
                            </circle>
                        </g>
                        <foreignObject x="570" y="167" width="100" height="30" class="block overflow-visible" style="opacity: 0; animation: labelAppear 0.4s ease-out 1.3s forwards;">
                            <div class="flex items-center justify-center h-full">
                                <span class="whitespace-nowrap rounded-md border border-[#0a0a0a]/80 bg-[#0a0a0a]/90 px-2.5 py-0.5 text-xs font-semibold text-white shadow-lg backdrop-blur-md">Surabaya</span>
                            </div>
                        </foreignObject>

                        {{-- Semarang (Arrival: 2.4s) --}}
                        <g>
                            <circle cx="433" cy="168" r="7" fill="none" stroke="#ffaa00" stroke-width="1" opacity="0">
                                <animate attributeName="r" values="7;12.6;7" dur="2.5s" begin="2.4s" repeatCount="indefinite"/>
                                <animate attributeName="opacity" values="0;0.8;0.2;0.8" dur="2.5s" begin="2.4s" repeatCount="indefinite"/>
                            </circle>
                            <circle cx="433" cy="168" r="3.5" fill="#ffaa00" filter="url(#glow-effect)" opacity="0">
                                <animate attributeName="opacity" from="0" to="1" dur="0.3s" begin="2.4s" fill="freeze"/>
                            </circle>
                        </g>
                        <foreignObject x="383" y="134" width="100" height="30" class="block overflow-visible" style="opacity: 0; animation: labelAppear 0.4s ease-out 2.5s forwards;">
                            <div class="flex items-center justify-center h-full">
                                <span class="whitespace-nowrap rounded-md border border-[#0a0a0a]/80 bg-[#0a0a0a]/90 px-2.5 py-0.5 text-xs font-semibold text-white shadow-lg backdrop-blur-md">Semarang</span>
                            </div>
                        </foreignObject>

                        {{-- Malang (Arrival: 3.6s) --}}
                        <g>
                            <circle cx="610" cy="284" r="7" fill="none" stroke="#ffaa00" stroke-width="1" opacity="0">
                                <animate attributeName="r" values="7;12.6;7" dur="2.5s" begin="3.6s" repeatCount="indefinite"/>
                                <animate attributeName="opacity" values="0;0.8;0.2;0.8" dur="2.5s" begin="3.6s" repeatCount="indefinite"/>
                            </circle>
                            <circle cx="610" cy="284" r="3.5" fill="#ffaa00" filter="url(#glow-effect)" opacity="0">
                                <animate attributeName="opacity" from="0" to="1" dur="0.3s" begin="3.6s" fill="freeze"/>
                            </circle>
                        </g>
                        <foreignObject x="560" y="250" width="100" height="30" class="block overflow-visible" style="opacity: 0; animation: labelAppear 0.4s ease-out 3.7s forwards;">
                            <div class="flex items-center justify-center h-full">
                                <span class="whitespace-nowrap rounded-md border border-[#0a0a0a]/80 bg-[#0a0a0a]/90 px-2.5 py-0.5 text-xs font-semibold text-white shadow-lg backdrop-blur-md">Malang</span>
                            </div>
                        </foreignObject>

                        {{-- Banyuwangi (Arrival: 3.6s) --}}
                        <g>
                            <circle cx="750" cy="311" r="7" fill="none" stroke="#ffaa00" stroke-width="1" opacity="0">
                                <animate attributeName="r" values="7;12.6;7" dur="2.5s" begin="3.6s" repeatCount="indefinite"/>
                                <animate attributeName="opacity" values="0;0.8;0.2;0.8" dur="2.5s" begin="3.6s" repeatCount="indefinite"/>
                            </circle>
                            <circle cx="750" cy="311" r="3.5" fill="#ffaa00" filter="url(#glow-effect)" opacity="0">
                                <animate attributeName="opacity" from="0" to="1" dur="0.3s" begin="3.6s" fill="freeze"/>
                            </circle>
                        </g>
                        <foreignObject x="700" y="277" width="100" height="30" class="block overflow-visible" style="opacity: 0; animation: labelAppear 0.4s ease-out 3.7s forwards;">
                            <div class="flex items-center justify-center h-full">
                                <span class="whitespace-nowrap rounded-md border border-[#0a0a0a]/80 bg-[#0a0a0a]/90 px-2.5 py-0.5 text-xs font-semibold text-white shadow-lg backdrop-blur-md">Banyuwangi</span>
                            </div>
                        </foreignObject>
                    </g>
                </svg>
            </div>

            {{-- Legend --}}
            <div class="mt-6 flex flex-wrap items-center justify-center gap-6 text-sm text-[#555555]">
                <div class="flex items-center gap-2">
                    <div class="h-3 w-3 rounded-full bg-[#ff750f] shadow-lg shadow-[#ff750f]/30"></div>
                    <p>Hub Utama (Ngawi)</p>
                </div>
                <div class="flex items-center gap-2">
                    <div class="h-3 w-3 rounded-full bg-[#ffaa00]"></div>
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
            </div>

            <div class="grid grid-cols-1 gap-5 lg:grid-cols-5" x-data="{ activeTab: 'company' }">
                {{-- Kisah TransNgawi / Biografi Mas Amba (70%) --}}
                <div class="card flex flex-col overflow-hidden p-6 sm:p-8 lg:col-span-3 lg:p-10">
                    {{-- Toggle Buttons (Desktop Only) --}}
                    <div class="mb-6 hidden lg:flex gap-2">
                        <button 
                            @click="activeTab = 'company'" 
                            :class="activeTab === 'company' ? 'bg-[#ff750f] text-white' : 'bg-[#e6e6e6] text-[#1a1a1a] hover:bg-[#d4d4d4]'"
                            class="rounded-lg px-4 py-2 text-sm font-semibold transition-colors"
                        >
                            Kisah TransNgawi
                        </button>
                        <button 
                            @click="activeTab = 'founder'" 
                            :class="activeTab === 'founder' ? 'bg-[#ff750f] text-white' : 'bg-[#e6e6e6] text-[#1a1a1a] hover:bg-[#d4d4d4]'"
                            class="rounded-lg px-4 py-2 text-sm font-semibold transition-colors"
                        >
                            Biografi Mas Amba
                        </button>
                    </div>

                    {{-- Content: Kisah TransNgawi --}}
                    <div x-show="activeTab === 'company'">

                        <h3 class="text-2xl font-bold text-[#1a1a1a]">Perjalanan TransNgawi</h3>

                        <div class="mt-6 space-y-4 text-sm leading-relaxed text-[#555555]">
                            <p>
                                TransNgawi hadir dari sebuah keyakinan sederhana: <strong class="text-[#1a1a1a]">rakyat Indonesia harus memperoleh transportasi dengan layanan terbaik dengan harga paling terjangkau</strong>
                            </p>
                            <p>
                                Kami memulai dengan melihat keresahan yang sama. Banyak pelajar dan pekerja muda yang harus memilih antara kenyamanan atau harga yang masuk akal. TransNgawi hadir untuk mematahkan pilihan itu.
                            </p>
                            <p>
                                Dengan tiga kelas layanan, Sukian, SukianPlus, dan SukianPro, kami memberikan fleksibilitas agar setiap pelanggan bisa menyesuaikan perjalanan dengan kebutuhan dan budget mereka.
                            </p>
                            <p>
                                Setiap detail kami rancang untuk pengalaman yang lebih baik: dari proses booking yang mudah, armada yang terawat, hingga pelayanan yang ramah. Kami bukan sekadar perusahaan bus. Kami adalah <strong class="text-[#1a1a1a]">teman perjalanan</strong> yang memahami kebutuhan generasi muda.
                            </p>
                        </div>
                    </div>

                    {{-- Content: Biografi Mas Amba --}}
                    <div x-show="activeTab === 'founder'" class="hidden lg:block">

                        <h3 class="text-2xl font-bold text-[#1a1a1a]">Mas Amba S.T</h3>
                        <p class="mt-1 text-sm font-medium text-[#ff750f]">Founder & CEO TransNgawi</p>

                        <div class="mt-6 space-y-4 text-sm leading-relaxed text-[#555555]">
                            <p>
                                Mas Amba adalah insinyur teknik transportasi lulusan Institut Teknologi Sepuluh Nopember (ITS) Surabaya. Sejak kuliah, ia sudah aktif meneliti pola mobilitas antarkota dan transportasi publik di Jawa.
                            </p>
                            <p>
                                Setelah lulus, ia bekerja di beberapa perusahaan transportasi nasional sebelum memutuskan untuk membangun TransNgawi pada tahun 2024. Visinya sederhana: membuat perjalanan antarkota lebih mudah diakses oleh anak muda Indonesia tanpa mengorbankan kenyamanan.
                            </p>
                            <p>
                                "Saya melihat banyak anak muda yang frustasi dengan transportasi antarkota. Mereka ingin sesuatu yang lebih baik, tapi harganya tidak ramah di kantong. TransNgawi ada untuk mengisi celah itu."
                            </p>
                            <p>
                                Dengan pengalaman lebih dari 10 tahun di industri transportasi, Mas Amba memastikan setiap keputusan TransNgawi berpusat pada kebutuhan nyata pelanggan, bukan sekadar keuntungan semata.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Pendiri (30%) --}}
                <div class="card flex flex-col overflow-hidden lg:col-span-2">
                    <div class="relative min-h-[320px] bg-[#e6e6e6] lg:min-h-full lg:flex-1">
                        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/masamba.jpg') }}')"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0a0a]/80 via-transparent to-transparent"></div>
                    </div>
                    <div class="p-6 sm:p-8">
                        <h3 class="text-xl font-bold text-[#1a1a1a]">Mas Amba S.T</h3>
                        <p class="mt-1 text-sm font-medium text-[#ff750f]">Founder & CEO</p>
                        <div class="mt-4 space-y-3 text-sm leading-relaxed text-[#555555]">
                            <p>
                                Mas Amba adalah insinyur teknik transportasi lulusan Institut Teknologi Sepuluh Nopember (ITS) Surabaya. Sejak kuliah, ia sudah aktif meneliti pola mobilitas antarkota dan transportasi publik di Jawa, khususnya di Ngawi.
                            </p>
                            <p>
                                Setelah lulus, ia bekerja di beberapa perusahaan transportasi nasional sebelum memutuskan untuk membangun TransNgawi pada tahun 2024. Visinya sederhana: membuat perjalanan antarkota lebih mudah diakses oleh anak muda Indonesia tanpa mengorbankan kenyamanan.
                            </p>
                            <p>
                                "Saya melihat banyak pemuda Ngawi yang frustasi dengan transportasi antarkota. Mereka ingin sesuatu yang lebih baik, tapi harganya tidak ramah di kantong. TransNgawi ada untuk mengisi celah itu."
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
