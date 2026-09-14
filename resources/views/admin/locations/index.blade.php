@extends('layouts.admin')

@section('title', 'Lokasi')

@section('content')
    <div class="container-app">
        <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
            <div class="max-w-2xl">
                <h1 class="text-3xl font-bold tracking-tight">Lokasi</h1>
                <p class="mt-2 text-base text-[#555555]">Tandai ibu kota dan tempat penting — aturan ANTIBU/SATSET membaca dari sini.</p>
            </div>
            <a href="{{ route('admin.locations.create') }}" class="btn-primary">Tambah Lokasi</a>
        </div>

        <div class="card overflow-hidden">
            @if ($locations->isEmpty())
                <p class="p-6 text-sm text-[#555555] md:p-8">Belum ada lokasi. Tambahkan lokasi pertama.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[640px] text-left text-sm">
                        <thead>
                            <tr class="border-b border-[#e6e6e6] text-xs uppercase tracking-wider text-[#555555]">
                                <th class="px-6 py-3 font-semibold">Nama</th>
                                <th class="px-6 py-3 font-semibold">Ibu Kota</th>
                                <th class="px-6 py-3 font-semibold">Tempat Penting</th>
                                <th class="px-6 py-3 text-right font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($locations as $location)
                                <tr class="border-b border-[#e6e6e6] last:border-0">
                                    <td class="px-6 py-3 font-semibold">{{ $location->name }}</td>
                                    <td class="px-6 py-3">{{ $location->is_capital ? 'Ya' : '—' }}</td>
                                    <td class="px-6 py-3">{{ $location->is_important ? 'Ya' : '—' }}</td>
                                    <td class="px-6 py-3">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.locations.edit', $location) }}" class="btn-secondary px-3 py-1.5 text-xs">Ubah</a>
                                            <form method="POST" action="{{ route('admin.locations.destroy', $location) }}" onsubmit="return confirm('Hapus lokasi ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-secondary px-3 py-1.5 text-xs">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="border-t border-[#e6e6e6] px-6 py-4">
                    {{ $locations->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
