@extends('layouts.customer')

@section('title', 'Perjalanan Saya')

@section('content')
    <section class="bg-[#faf9f8] py-16 md:py-24">
        <div class="container-app">
            <div class="mb-8 max-w-2xl">
                <h1 class="text-3xl font-bold tracking-tight text-[#1a1a1a] sm:text-4xl">Perjalanan Saya</h1>
                <p class="mt-3 text-base text-[#555555]">Semua tiketmu, yang akan datang maupun yang sudah selesai.</p>
            </div>

            <div class="mb-6 flex gap-2">
                <a href="{{ route('my-trips.index', ['tab' => 'upcoming']) }}" class="rounded-lg px-4 py-2 text-sm font-semibold transition-colors @if($tab === 'upcoming') bg-[#ff750f] text-white @else bg-[#e6e6e6] text-[#1a1a1a] hover:bg-[#d4d4d4] @endif">Mendatang</a>
                <a href="{{ route('my-trips.index', ['tab' => 'past']) }}" class="rounded-lg px-4 py-2 text-sm font-semibold transition-colors @if($tab === 'past') bg-[#ff750f] text-white @else bg-[#e6e6e6] text-[#1a1a1a] hover:bg-[#d4d4d4] @endif">Selesai</a>
                <a href="{{ route('my-trips.index', ['tab' => 'all']) }}" class="rounded-lg px-4 py-2 text-sm font-semibold transition-colors @if($tab === 'all') bg-[#ff750f] text-white @else bg-[#e6e6e6] text-[#1a1a1a] hover:bg-[#d4d4d4] @endif">Semua</a>
            </div>

            @if (count($trips) > 0)
                <div class="space-y-4">
                    @foreach ($trips as $trip)
                        <div class="card px-6 py-5 md:px-8">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-base font-bold text-[#1a1a1a]">{{ $trip['origin'] }} &rarr; {{ $trip['destination'] }}</p>
                                    <p class="mt-1 text-sm text-[#555555]">{{ $trip['code'] }} &middot; {{ $trip['date'] }}</p>
                                </div>
                                <span class="inline-flex w-fit items-center rounded-full bg-[#ff750f]/10 px-3 py-1 text-xs font-bold text-[#ff750f]">{{ ucfirst($trip['status']) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card px-6 py-12 text-center md:px-8">
                    <p class="text-base font-bold text-[#1a1a1a]">Belum ada perjalanan di sini.</p>
                    <p class="mt-2 text-sm text-[#555555]">Coba tab lain atau cari perjalanan baru.</p>
                    <a href="{{ route('search.index') }}" class="btn-primary mt-6">Cari Perjalanan</a>
                </div>
            @endif
        </div>
    </section>
@endsection
