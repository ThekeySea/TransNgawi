@extends('layouts.customer')

@section('title', 'Rute Perjalanan')

@section('content')
    {{-- Hero --}}
    <section class="relative -mt-16 overflow-hidden bg-[#0a0a0a] py-28 lg:-mt-20 lg:py-36">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-br from-[#ff750f]/20 via-transparent to-transparent"></div>
        </div>
        <div class="container-app relative z-10">
            <div class="max-w-3xl">
                <h1 class="text-4xl font-extrabold leading-tight tracking-tight text-white sm:text-5xl lg:text-6xl">
                    Rute Perjalanan
                </h1>
                <p class="mt-6 max-w-xl text-base leading-relaxed text-neutral-400 sm:text-lg">
                    Tiga jenis layanan, satu tujuan: sampai dengan nyaman. Pilih yang rutenya paling pas buat kamu.
                </p>
            </div>
        </div>
    </section>

    {{-- Daftar layanan + rute --}}
    <section class="bg-[#faf9f8] py-16 md:py-24">
        <div class="container-app">
            @php
                $serviceDescriptions = [
                    'antibu' => 'Rute jarak jauh antarprovinsi atau menuju ibu kota. Buat perjalanan jauh yang butuh duduk nyaman.',
                    'satset' => 'Menghubungkan tempat-tempat penting — misalnya pelabuhan atau bandara. Yang penting fungsinya, sampai tujuan dengan beres.',
                    'biasane' => 'Perjalanan reguler antarkota ke kota-kota menengah atau besar, di dalam maupun luar provinsi.',
                ];
                $serviceInitials = ['antibu' => 'A', 'satset' => 'S', 'biasane' => 'B'];
            @endphp

            <div class="space-y-8">
                @foreach ($serviceTypes as $service)
                    @php
                        $serviceRoutes = array_values(array_filter($routes, fn ($r) => $r['category'] === $service['code']));
                    @endphp
                    <div class="card overflow-hidden">
                        <div class="px-6 py-5 md:px-8">
                            <div class="flex items-center gap-3">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#ff750f]/10">
                                    <span class="text-xl font-bold text-[#ff750f]">{{ $serviceInitials[$service['code']] ?? substr($service['name'], 0, 1) }}</span>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-[#1a1a1a]">{{ $service['name'] }}</h2>
                                    <p class="text-xs text-[#555555]">{{ $service['label'] }}</p>
                                </div>
                            </div>
                            <p class="mt-4 max-w-2xl text-sm leading-relaxed text-[#555555]">{{ $serviceDescriptions[$service['code']] ?? '' }}</p>
                        </div>
                        <div class="border-t border-[#e6e6e6] px-6 py-5 md:px-8">
                            <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-[#555555]">Contoh Rute</p>
                            @if (count($serviceRoutes) > 0)
                                <ul class="grid grid-cols-1 gap-2.5 sm:grid-cols-2 lg:grid-cols-3">
                                    @foreach ($serviceRoutes as $route)
                                        <li class="flex items-center justify-between gap-3 rounded-[var(--radius-sm)] border border-[#e6e6e6] bg-[#faf9f8] px-4 py-3">
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
