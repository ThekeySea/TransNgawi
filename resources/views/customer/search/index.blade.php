@extends('layouts.customer')

@section('title', 'Hasil Pencarian')

@section('content')
    <x-ui.page-header
        title="Hasil Pencarian"
        :description="'Menampilkan perjalanan dari '.($filters['origin'] ?? 'Semua kota').' ke '.($filters['destination'] ?? 'Semua kota')"
    />

    <section class="section-spacing bg-surface" x-data="searchFilters()">
        <div class="container-app">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
                <p class="text-sm text-text-muted">{{ count($trips) }} perjalanan ditemukan</p>
                <button type="button" class="btn-secondary btn-sm lg:hidden" @click="toggle()">
                    Filter & Urutkan
                </button>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">
                <aside :class="open ? 'block' : 'hidden lg:block'" class="lg:col-span-1">
                    <div class="card sticky top-24">
                        <div class="card-body space-y-4">
                            <h3 class="font-bold text-text">Filter</h3>

                            <x-ui.select label="Urutkan" name="sort" id="sort">
                                <option value="departure">Waktu Keberangkatan</option>
                                <option value="price">Harga Terendah</option>
                                <option value="duration">Durasi Terpendek</option>
                            </x-ui.select>

                            <x-ui.select label="Kelas" name="class_filter" id="class_filter">
                                <option value="">Semua Kelas</option>
                                <option value="sukian">Sukian</option>
                                <option value="sukianplus">SukianPlus</option>
                                <option value="sukianpro">SukianPro</option>
                            </x-ui.select>
                        </div>
                    </div>
                </aside>

                <div class="space-y-4 lg:col-span-3">
                    @forelse ($trips as $trip)
                        <x-booking.trip-card :trip="$trip" />
                    @empty
                        <x-ui.empty-state
                            title="Tidak ada perjalanan ditemukan"
                            description="Coba ubah tanggal, rute, atau jenis layanan pencarian Anda."
                            :action="route('home')"
                            action-label="Cari Ulang"
                        />
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
