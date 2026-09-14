@extends('layouts.admin')

@section('title', 'Bus')

@section('content')
    <div class="container-app">
        <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
            <div class="max-w-2xl">
                <h1 class="text-3xl font-bold tracking-tight">Bus</h1>
                <p class="mt-2 text-base text-[#555555]">Model menentukan template kursi trip: BIASANE 40 kursi, ANTIBU/SATSET 30 kursi.</p>
            </div>
            <a href="{{ route('admin.buses.create') }}" class="btn-primary">Tambah Bus</a>
        </div>

        <div class="card overflow-hidden">
            @if ($buses->isEmpty())
                <p class="p-6 text-sm text-[#555555] md:p-8">Belum ada bus. Tambahkan bus pertama.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[640px] text-left text-sm">
                        <thead>
                            <tr class="border-b border-[#e6e6e6] text-xs uppercase tracking-wider text-[#555555]">
                                <th class="px-6 py-3 font-semibold">Pelat</th>
                                <th class="px-6 py-3 font-semibold">Model</th>
                                <th class="px-6 py-3 font-semibold">Status</th>
                                <th class="px-6 py-3 text-right font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($buses as $bus)
                                <tr class="border-b border-[#e6e6e6] last:border-0">
                                    <td class="px-6 py-3 font-semibold">{{ $bus->plate_number }}</td>
                                    <td class="px-6 py-3">{{ $bus->model_type->label() }}</td>
                                    <td class="px-6 py-3">{{ $bus->status }}</td>
                                    <td class="px-6 py-3">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.buses.edit', $bus) }}" class="btn-secondary px-3 py-1.5 text-xs">Ubah</a>
                                            <form method="POST" action="{{ route('admin.buses.destroy', $bus) }}" onsubmit="return confirm('Hapus bus ini?')">
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
                    {{ $buses->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
