@extends('layouts.admin')

@section('title', 'Sesi Bantuan #' . $session->id)

@section('content')
    <div class="container-app">
        <div class="mb-6">
            <a href="{{ route('admin.help.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-[#ff750f] hover:underline">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Bantuan
            </a>
        </div>

        @if (session('status'))
            <div class="mb-6 rounded-[var(--radius-sm)] border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            {{-- Chat --}}
            <div class="lg:col-span-2">
                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-xl font-bold">#{{ $session->id }} — {{ $session->subject }}</h1>
                                <p class="mt-1 text-sm text-[#555555]">
                                    {{ $session->user->name ?? 'User #' . $session->user_id }} · {{ $session->topic }}
                                </p>
                            </div>
                            @php
                                $badgeClass = match($session->status) {
                                    'WAITING' => 'bg-amber-100 text-amber-700',
                                    'ACTIVE' => 'bg-blue-100 text-blue-700',
                                    'CLOSED' => 'bg-neutral-100 text-neutral-600',
                                    default => 'bg-neutral-100 text-neutral-600',
                                };
                            @endphp
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold {{ $badgeClass }}">
                                {{ $session->status }}
                            </span>
                        </div>

                        {{-- Messages --}}
                        <div class="mt-6 space-y-4 max-h-[500px] overflow-y-auto" id="messages">
                            @forelse ($session->messages as $message)
                                <div class="flex {{ $message->sender_type === 'admin' ? 'justify-end' : 'justify-start' }}">
                                    <div class="max-w-[80%] rounded-[var(--radius-md)] px-4 py-3 {{ $message->sender_type === 'admin' ? 'bg-[#ff750f] text-white' : 'bg-[#faf9f8] text-[#1a1a1a]' }}">
                                        <p class="text-xs font-semibold {{ $message->sender_type === 'admin' ? 'text-white/80' : 'text-[#555555]' }}">
                                            {{ $message->sender_type === 'admin' ? 'Admin' : ($session->user->name ?? 'Pelanggan') }}
                                            · {{ $message->created_at->format('H:i') }}
                                        </p>
                                        <p class="mt-1 text-sm">{{ $message->message }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-sm text-[#555555]">Belum ada pesan.</p>
                            @endforelse
                        </div>

                        {{-- Actions --}}
                        @if ($session->status === 'WAITING')
                            <div class="mt-4">
                                <form action="{{ route('admin.help.accept', $session) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-2 rounded-[var(--radius-sm)] bg-[#ff750f] px-5 py-2.5 text-sm font-semibold text-white transition-all hover:bg-[#e5680d]">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Terima Sesi
                                    </button>
                                </form>
                            </div>
                        @endif

                        @if (in_array($session->status, ['WAITING', 'ACTIVE']))
                            <form action="{{ route('admin.help.reply', $session) }}" method="POST" class="mt-6 flex gap-3">
                                @csrf
                                <input type="text" name="message" class="input flex-1" placeholder="Ketik balasan..." required autocomplete="off">
                                <button type="submit" class="btn-primary">Kirim</button>
                            </form>
                        @endif

                        @if (in_array($session->status, ['WAITING', 'ACTIVE']))
                            <div class="mt-4">
                                <form action="{{ route('admin.help.close', $session) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-sm font-semibold text-[#555555] hover:text-[#1a1a1a]">Tutup Sesi</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1">
                <div class="card sticky top-24">
                    <div class="card-body">
                        <h3 class="text-lg font-bold">Detail Sesi</h3>
                        <dl class="mt-4 space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-[#555555]">Pelanggan</dt>
                                <dd class="font-semibold">{{ $session->user->name ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-[#555555]">Email</dt>
                                <dd class="font-semibold">{{ $session->user->email ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-[#555555]">Topik</dt>
                                <dd class="font-semibold">{{ $session->topic }}</dd>
                            </div>
                            @if ($session->booking)
                                <div class="flex justify-between">
                                    <dt class="text-[#555555]">Booking</dt>
                                    <dd>
                                        <a href="{{ route('admin.transactions.show', $session->booking) }}" class="font-semibold text-[#ff750f] hover:underline">
                                            {{ $session->booking->code }}
                                        </a>
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-[#555555]">Rute</dt>
                                    <dd class="font-semibold">{{ $session->booking->trip->route->origin->name }} → {{ $session->booking->trip->route->destination->name }}</dd>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <dt class="text-[#555555]">Dibuat</dt>
                                <dd class="font-semibold">{{ $session->created_at->format('d M Y H:i') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const messages = document.getElementById('messages');
        if (messages) {
            messages.scrollTop = messages.scrollHeight;
        }
    </script>
    @endpush
@endsection
