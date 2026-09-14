@extends('layouts.customer')

@section('title', 'Kelas Perjalanan')

@section('content')
    {{-- Hero --}}
    <section class="relative -mt-16 overflow-hidden bg-[#0a0a0a] py-28 lg:-mt-20 lg:py-36">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-br from-[#ff750f]/20 via-transparent to-transparent"></div>
        </div>
        <div class="container-app relative z-10">
            <div class="max-w-3xl">
                <h1 class="text-4xl font-extrabold leading-tight tracking-tight text-white sm:text-5xl lg:text-6xl">
                    Pilih Kelas Sesukamu
                </h1>
                <p class="mt-6 max-w-xl text-base leading-relaxed text-neutral-400 sm:text-lg">
                    Setiap kelas punya ceritanya masing-masing. Yang pasti, semuanya tetap nyaman — tinggal sesuaikan sama kebutuhanmu.
                </p>
            </div>
        </div>
    </section>

    {{-- Perbandingan 3 Kelas — Desktop --}}
    <section class="hidden bg-[#faf9f8] py-16 md:block md:py-24">
        <div class="container-app">
            <div class="mb-12 max-w-2xl">
                <h2 class="text-3xl font-bold tracking-tight text-[#1a1a1a] sm:text-4xl">Apa Bedanya?</h2>
                <p class="mt-3 text-base text-[#555555]">Tiga kelas, tiga gaya perjalanan. Pilih yang paling cocok buat kamu.</p>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                {{-- Sukian --}}
                <div class="card flex flex-col overflow-hidden">
                    <div class="px-6 py-5 md:px-8">
                        <div class="flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#ff750f]/10">
                                <span class="text-xl font-bold text-[#ff750f]">S</span>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-xl font-bold text-[#1a1a1a]">Sukian</h3>
                                    <span class="rounded-full bg-[#e6e6e6] px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-[#555555]">Ekonomis</span>
                                </div>
                                <p class="text-xs text-[#555555]">Basic</p>
                            </div>
                        </div>
                        <p class="mt-4 text-sm leading-relaxed text-[#555555]">Cukup, simpel, dan tetap nyaman. Buat kamu yang mau perjalanan tanpa ribet.</p>
                    </div>
                    <div class="mt-auto border-t border-[#e6e6e6] px-6 py-5 md:px-8">
                        <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-[#555555]">Yang Dapat Kamu Dapatkan</p>
                        <ul class="space-y-2.5">
                            <li class="flex items-center gap-2.5">
                                <svg class="h-4 w-4 shrink-0 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-sm text-[#1a1a1a]">Snack gratis</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <svg class="h-4 w-4 shrink-0 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-sm text-[#1a1a1a]">Air mineral</span>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- SukianPlus --}}
                <div class="relative card flex flex-col overflow-hidden ring-2 ring-[#ff750f]">
                    <div class="px-6 py-5 md:px-8">
                        <div class="flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#ff750f]/10">
                                <span class="text-xl font-bold text-[#ff750f]">S+</span>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-xl font-bold text-[#1a1a1a]">SukianPlus</h3>
                                    <span class="rounded-full bg-[#ff750f]/10 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-[#ff750f]">Populer</span>
                                </div>
                                <p class="text-xs text-[#555555]">Best Value</p>
                            </div>
                        </div>
                        <p class="mt-4 text-sm leading-relaxed text-[#555555]">Yang paling banyak dipilih. Kursi lebih lega, ada bonus massage pula.</p>
                    </div>
                    <div class="mt-auto border-t border-[#e6e6e6] px-6 py-5 md:px-8">
                        <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-[#555555]">Yang Dapat Kamu Dapatkan</p>
                        <ul class="space-y-2.5">
                            <li class="flex items-center gap-2.5">
                                <svg class="h-4 w-4 shrink-0 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-sm text-[#1a1a1a]">Kursi lebih lega</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <svg class="h-4 w-4 shrink-0 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-sm text-[#1a1a1a]">Massage</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <svg class="h-4 w-4 shrink-0 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-sm text-[#1a1a1a]">Snack & air mineral</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <svg class="h-4 w-4 shrink-0 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-sm text-[#1a1a1a]">Souvenir keychain</span>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- SukianPro --}}
                <div class="card flex flex-col overflow-hidden border-[#2a2a2a] bg-[#1a1a1a]">
                    <div class="px-6 py-5 md:px-8">
                        <div class="flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10">
                                <span class="text-xl font-bold text-white">SP</span>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-xl font-bold text-white">SukianPro</h3>
                                    <span class="rounded-full bg-[#ff750f] px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white">Premium</span>
                                </div>
                                <p class="text-xs text-neutral-400">Premium</p>
                            </div>
                        </div>
                        <p class="mt-4 text-sm leading-relaxed text-neutral-300">Buat kamu yang butuh tidur nyenyak di perjalanan jauh. Ada cabin sendiri, TV pribadi, dan fasilitas lengkap.</p>
                        <div class="mt-3 inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-1">
                            <svg class="h-3 w-3 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-xs text-neutral-400">Tersedia di rute ANTIBU & SATSET</span>
                        </div>
                    </div>
                    <div class="mt-auto border-t border-white/10 px-6 py-5 md:px-8">
                        <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-neutral-400">Yang Dapat Kamu Dapatkan</p>
                        <ul class="space-y-2.5">
                            <li class="flex items-center gap-2.5">
                                <svg class="h-4 w-4 shrink-0 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-sm text-white">Compact sleeping cabin</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <svg class="h-4 w-4 shrink-0 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-sm text-white">Massage bed</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <svg class="h-4 w-4 shrink-0 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-sm text-white">Snack & air mineral</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <svg class="h-4 w-4 shrink-0 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-sm text-white">Souvenir keychain</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <svg class="h-4 w-4 shrink-0 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-sm text-white">Personal TV — Netflix, YouTube, Spotify</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Detail Tiap Kelas — Mobile & Tablet --}}
    <section class="block bg-white py-16 md:hidden md:py-24">
        <div class="container-app">
            <div class="mb-12 max-w-2xl">
                <h2 class="text-3xl font-bold tracking-tight text-[#1a1a1a] sm:text-4xl">Kenali Lebih Dekat</h2>
                <p class="mt-3 text-base text-[#555555]">Ini yang bikin tiap kelas punya karakternya sendiri.</p>
            </div>

            <div class="space-y-8">
                {{-- Sukian --}}
                <div class="card overflow-hidden">
                    <div class="grid grid-cols-1 md:grid-cols-3">
                        <div class="flex items-center justify-center bg-[#faf9f8] p-8 md:p-12">
                            <div class="flex h-20 w-20 items-center justify-center rounded-3xl bg-[#ff750f]/10">
                                <span class="text-3xl font-bold text-[#ff750f]">S</span>
                            </div>
                        </div>
                        <div class="col-span-2 p-8 md:p-12">
                            <div class="flex items-center gap-2">
                                <h3 class="text-2xl font-bold text-[#1a1a1a]">Sukian</h3>
                                <span class="rounded-full bg-[#e6e6e6] px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-[#555555]">Ekonomis</span>
                            </div>
                            <p class="mt-2 text-sm text-[#555555]">Basic, tapi tetap oke. Cocok buat perjalanan singkat atau kalau kamu memang nggak butuh banyak bonus.</p>
                            <div class="mt-6 space-y-3">
                                <div class="flex items-start gap-3">
                                    <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#ff750f]/10">
                                        <svg class="h-3 w-3 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                    <span class="text-sm text-[#1a1a1a]">Snack ringan buat menemani perjalanan</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#ff750f]/10">
                                        <svg class="h-3 w-3 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                    <span class="text-sm text-[#1a1a1a]">Air mineral biar nggak haus di jalan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SukianPlus --}}
                <div class="card overflow-hidden ring-2 ring-[#ff750f]">
                    <div class="grid grid-cols-1 md:grid-cols-3">
                        <div class="flex items-center justify-center bg-[#ff750f]/5 p-8 md:p-12">
                            <div class="flex h-20 w-20 items-center justify-center rounded-3xl bg-[#ff750f]/10">
                                <span class="text-3xl font-bold text-[#ff750f]">S+</span>
                            </div>
                        </div>
                        <div class="col-span-2 p-8 md:p-12">
                            <div class="flex items-center gap-2">
                                <h3 class="text-2xl font-bold text-[#1a1a1a]">SukianPlus</h3>
                                <span class="rounded-full bg-[#ff750f] px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white">Populer</span>
                            </div>
                            <p class="mt-2 text-sm text-[#555555]">Ini favorit banyak orang. Kursinya lebih lega, ada massage, dan dapat souvenir kecil. Value-nya berasa banget.</p>
                            <div class="mt-6 space-y-3">
                                <div class="flex items-start gap-3">
                                    <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#ff750f]/10">
                                        <svg class="h-3 w-3 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                    <span class="text-sm text-[#1a1a1a]">Kursi lebih lega — ruang kaki ekstra, badan nggak sempit</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#ff750f]/10">
                                        <svg class="h-3 w-3 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                    <span class="text-sm text-[#1a1a1a]">Massage di kursi — relaksasi sambil duduk manis</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#ff750f]/10">
                                        <svg class="h-3 w-3 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                    <span class="text-sm text-[#1a1a1a]">Snack & air mineral — tetap ada seperti di Sukian</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#ff750f]/10">
                                        <svg class="h-3 w-3 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                    <span class="text-sm text-[#1a1a1a]">Souvenir keychain — kenang-kenangan kecil dari TransNgawi</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SukianPro --}}
                <div class="card overflow-hidden border-[#2a2a2a] bg-[#1a1a1a]">
                    <div class="grid grid-cols-1 md:grid-cols-3">
                        <div class="flex items-center justify-center bg-[#0a0a0a] p-8 md:p-12">
                            <div class="flex h-20 w-20 items-center justify-center rounded-3xl bg-white/10">
                                <span class="text-3xl font-bold text-white">SP</span>
                            </div>
                        </div>
                        <div class="col-span-2 p-8 md:p-12">
                            <div class="flex items-center gap-2">
                                <h3 class="text-2xl font-bold text-white">SukianPro</h3>
                                <span class="rounded-full bg-[#ff750f] px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white">Premium</span>
                            </div>
                            <p class="mt-2 text-sm text-neutral-300">Premium, tapi tetap masuk akal. Buat perjalanan jauh yang butuh istirahat beneran — nggak cuma duduk doang.</p>
                            <div class="mt-3 inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-1">
                                <svg class="h-3 w-3 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-xs text-neutral-400">Tersedia di rute ANTIBU & SATSET aja</span>
                            </div>
                            <div class="mt-6 space-y-3">
                                <div class="flex items-start gap-3">
                                    <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#ff750f]/20">
                                        <svg class="h-3 w-3 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                    <span class="text-sm text-white">Compact sleeping cabin — tidur beneran, bukan rebahan setengah sadar</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#ff750f]/20">
                                        <svg class="h-3 w-3 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                    <span class="text-sm text-white">Massage bed — relaksasi maksimal selama perjalanan</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#ff750f]/20">
                                        <svg class="h-3 w-3 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                    <span class="text-sm text-white">Snack & air mineral — tetap ada seperti di kelas lain</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#ff750f]/20">
                                        <svg class="h-3 w-3 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                    <span class="text-sm text-white">Souvenir keychain — kenang-kenangan dari TransNgawi</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#ff750f]/20">
                                        <svg class="h-3 w-3 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                    <span class="text-sm text-white">Personal TV — Netflix, YouTube, Spotify tersedia</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Jenis Layanan --}}
    <section class="bg-[#faf9f8] py-16 md:py-24">
        <div class="container-app">
            <div class="mb-12 max-w-2xl">
                <h2 class="text-3xl font-bold tracking-tight text-[#1a1a1a] sm:text-4xl">Jenis Layanan</h2>
                <p class="mt-3 text-base text-[#555555]">Kalau kelas itu soal kenyamanan di dalam bus, layanan itu soal jenis rutenya. Tiga-tiganya bisa dipadukan sama kelas apa pun yang kamu pilih.</p>
            </div>

            @php
                $serviceDescriptions = [
                    'antibu' => 'Rute jarak jauh antarprovinsi atau menuju ibu kota. Buat perjalanan jauh yang butuh duduk nyaman.',
                    'satset' => 'Menghubungkan tempat-tempat penting — misalnya pelabuhan atau bandara. Yang penting fungsinya, sampai tujuan dengan beres.',
                    'biasane' => 'Perjalanan reguler antarkota ke kota-kota menengah atau besar, di dalam maupun luar provinsi.',
                ];
                $serviceInitials = ['antibu' => 'A', 'satset' => 'S', 'biasane' => 'B'];
            @endphp

            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                @foreach ($serviceTypes as $service)
                    @php
                        $serviceRoutes = array_values(array_filter($routes, fn ($r) => $r['category'] === $service['code']));
                    @endphp
                    <div class="card flex flex-col overflow-hidden">
                        <div class="px-6 py-5 md:px-8">
                            <div class="flex items-center gap-3">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#ff750f]/10">
                                    <span class="text-xl font-bold text-[#ff750f]">{{ $serviceInitials[$service['code']] ?? substr($service['name'], 0, 1) }}</span>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-[#1a1a1a]">{{ $service['name'] }}</h3>
                                    <p class="text-xs text-[#555555]">{{ $service['label'] }}</p>
                                </div>
                            </div>
                            <p class="mt-4 text-sm leading-relaxed text-[#555555]">{{ $serviceDescriptions[$service['code']] ?? '' }}</p>
                        </div>
                        <div class="mt-auto border-t border-[#e6e6e6] px-6 py-5 md:px-8">
                            <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-[#555555]">Contoh Rute</p>
                            @if (count($serviceRoutes) > 0)
                                <ul class="space-y-2.5">
                                    @foreach ($serviceRoutes as $route)
                                        <li class="flex items-center justify-between gap-3">
                                            <span class="text-sm text-[#1a1a1a]">{{ $route['origin'] }} &rarr; {{ $route['destination'] }}</span>
                                            <span class="shrink-0 text-xs text-[#999]">{{ $route['duration'] }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-sm text-[#999]">Belum ada contoh rute.</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <p class="mt-6 text-xs text-[#999]">Daftar di atas contoh rute (data prototype), bukan jadwal operasional resmi.</p>
        </div>
    </section>
@endsection