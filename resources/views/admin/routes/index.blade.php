@extends('layouts.admin')

@section('title', 'Rute')

@section('content')
    <div class="container-app">
        <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
            <div class="max-w-2xl">
                <h1 class="text-3xl font-bold tracking-tight">Rute</h1>
                <p class="mt-2 text-base text-[#555555]">Kelola rute perjalanan beserta kategori layanan.</p>
            </div>
            <a href="{{ route('admin.routes.create') }}" class="btn-primary">Tambah Rute</a>
        </div>

        {{-- Filter --}}
        <div class="mb-4 flex flex-wrap gap-2">
            <a href="{{ route('admin.routes.index') }}" class="rounded-full px-3 py-1.5 text-xs font-semibold transition-all {{ !$activeService ? 'bg-[#ff750f] text-white' : 'bg-[#e6e6e6] text-[#555555] hover:bg-[#ff750f]/10' }}">Semua</a>
            @foreach ($services as $service)
                <a href="{{ route('admin.routes.index', ['service' => $service->value]) }}" class="rounded-full px-3 py-1.5 text-xs font-semibold transition-all {{ $activeService === $service->value ? 'bg-[#ff750f] text-white' : 'bg-[#e6e6e6] text-[#555555] hover:bg-[#ff750f]/10' }}">{{ $service->name }}</a>
            @endforeach
        </div>

        <div class="card overflow-hidden">
            @if ($routes->isEmpty())
                <p class="p-6 text-sm text-[#555555] md:p-8">Belum ada rute. Tambahkan rute pertama.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[640px] text-left text-sm">
                        <thead>
                            <tr class="border-b border-[#e6e6e6] text-xs uppercase tracking-wider text-[#555555]">
                                <th class="px-6 py-3 font-semibold">Asal</th>
                                <th class="px-6 py-3 font-semibold">Tujuan</th>
                                <th class="px-6 py-3 font-semibold">Layanan</th>
                                <th class="px-6 py-3 text-right font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($routes as $route)
                                <tr class="border-b border-[#e6e6e6] last:border-0">
                                    <td class="px-6 py-3 font-semibold">{{ $route->origin->name }}</td>
                                    <td class="px-6 py-3 font-semibold">{{ $route->destination->name }}</td>
                                    <td class="px-6 py-3">
                                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold
                                            @if($route->service_category->value === 'antibu') bg-blue-100 text-blue-700
                                            @elseif($route->service_category->value === 'satset') bg-amber-100 text-amber-700
                                            @else bg-gray-100 text-gray-700 @endif">
                                            {{ strtoupper($route->service_category->name) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.routes.edit', $route) }}" class="btn-secondary px-3 py-1.5 text-xs">Ubah</a>
                                            <form method="POST" action="{{ route('admin.routes.destroy', $route) }}" onsubmit="return confirm('Hapus rute ini?')">
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
                    {{ $routes->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
