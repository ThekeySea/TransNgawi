@extends('layouts.admin')

@section('title', 'Bantuan')

@section('content')
    <div class="container-app">
        <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold tracking-tight">Bantuan</h1>
                <p class="mt-2 text-base text-[#555555]">Kelola sesi bantuan dari pelanggan.</p>
            </div>
        </div>

        {{-- Filters --}}
        <div class="card mb-6 p-4">
            <form action="{{ route('admin.help.index') }}" method="GET" class="flex flex-wrap items-end gap-3">
                <div class="min-w-[160px]">
                    <label class="input-label">Status</label>
                    <select name="status" class="select">
                        <option value="">Semua Status</option>
                        <option value="WAITING" {{ request('status') === 'WAITING' ? 'selected' : '' }}>Menunggu</option>
                        <option value="ACTIVE" {{ request('status') === 'ACTIVE' ? 'selected' : '' }}>Aktif</option>
                        <option value="CLOSED" {{ request('status') === 'CLOSED' ? 'selected' : '' }}>Ditutup</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary">Filter</button>
            </form>
        </div>

        {{-- Table --}}
        <div class="card overflow-hidden">
            @if ($sessions->isEmpty())
                <div class="flex flex-col items-center justify-center px-6 py-16 text-center">
                    <p class="text-sm text-[#555555]">Tidak ada sesi bantuan.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[700px] text-left text-sm">
                        <thead>
                            <tr class="border-b border-[#e6e6e6] text-xs uppercase tracking-wider text-[#555555]">
                                <th class="py-3 px-4 font-semibold">ID</th>
                                <th class="py-3 px-4 font-semibold">Pelanggan</th>
                                <th class="py-3 px-4 font-semibold">Topik</th>
                                <th class="py-3 px-4 font-semibold">Subjek</th>
                                <th class="py-3 px-4 font-semibold">Booking</th>
                                <th class="py-3 px-4 font-semibold">Status</th>
                                <th class="py-3 px-4 font-semibold">Waktu</th>
                                <th class="py-3 px-4 font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sessions as $session)
                                <tr class="border-b border-[#e6e6e6] last:border-0 hover:bg-[#faf9f8] {{ $session->status === 'WAITING' ? 'bg-amber-50/50' : '' }}">
                                    <td class="py-3 px-4 font-bold">#{{ $session->id }}</td>
                                    <td class="py-3 px-4">
                                        <p class="font-semibold">{{ $session->user->name ?? '-' }}</p>
                                        <p class="text-xs text-[#555555]">{{ $session->user->email ?? '-' }}</p>
                                    </td>
                                    <td class="py-3 px-4 text-xs">{{ $session->topic }}</td>
                                    <td class="py-3 px-4 font-semibold">{{ $session->subject }}</td>
                                    <td class="py-3 px-4 text-xs">{{ $session->booking->code ?? '-' }}</td>
                                    <td class="py-3 px-4">
                                        @php
                                            $badgeClass = match($session->status) {
                                                'WAITING' => 'bg-amber-100 text-amber-700',
                                                'ACTIVE' => 'bg-blue-100 text-blue-700',
                                                'CLOSED' => 'bg-neutral-100 text-neutral-600',
                                                default => 'bg-neutral-100 text-neutral-600',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $badgeClass }}">
                                            {{ $session->status }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-xs text-[#555555]">{{ $session->created_at->diffForHumans() }}</td>
                                    <td class="py-3 px-4">
                                        <a href="{{ route('admin.help.show', $session) }}" class="text-sm font-semibold text-[#ff750f] hover:underline">Buka</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-[#e6e6e6] px-4 py-3">
                    {{ $sessions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
