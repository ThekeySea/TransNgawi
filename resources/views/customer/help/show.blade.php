@extends('layouts.customer')

@section('title', 'Sesi Bantuan — ' . $session->subject)

@section('content')
    <section class="section-spacing bg-surface">
        <div class="container-app">
            <div class="mb-6">
                <a href="{{ route('help.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-brand hover:underline">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Kembali
                </a>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                {{-- Chat --}}
                <div class="lg:col-span-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-bold text-text">{{ $session->subject }}</h3>
                                @php
                                    $statusVariant = match($session->status) {
                                        'WAITING' => 'badge-warning',
                                        'ACTIVE' => 'badge-info',
                                        'RESOLVED', 'CLOSED' => 'badge-neutral',
                                        default => 'badge-neutral',
                                    };
                                @endphp
                                <span class="{{ $statusVariant }}">{{ $session->status }}</span>
                            </div>

                            {{-- Messages --}}
                            <div class="mt-6 space-y-4 max-h-[500px] overflow-y-auto" id="messages">
                                @forelse ($session->messages as $message)
                                    <div class="flex {{ $message->sender_type === 'customer' ? 'justify-end' : 'justify-start' }}">
                                        <div class="max-w-[80%] rounded-[var(--radius-md)] px-4 py-3 {{ $message->sender_type === 'customer' ? 'bg-[#ff750f] text-white' : 'bg-[#faf9f8] text-[#1a1a1a]' }}">
                                            <p class="text-xs font-semibold {{ $message->sender_type === 'customer' ? 'text-white/80' : 'text-[#555555]' }}">
                                                {{ $message->sender_type === 'customer' ? 'Anda' : 'Admin' }}
                                                · {{ $message->created_at->format('H:i') }}
                                            </p>
                                            <p class="mt-1 text-sm">{{ $message->message }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-sm text-[#555555]">Belum ada pesan.</p>
                                @endforelse
                            </div>

                            {{-- Reply Form --}}
                            @if (in_array($session->status, ['WAITING', 'ACTIVE']))
                                <form action="{{ route('help.reply', $session) }}" method="POST" class="mt-6 flex gap-3">
                                    @csrf
                                    <input type="text" name="message" class="input flex-1" placeholder="Ketik pesan..." required autocomplete="off">
                                    <button type="submit" class="btn-primary">Kirim</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="lg:col-span-1">
                    <div class="card sticky top-24">
                        <div class="card-body">
                            <h3 class="text-lg font-bold text-text">Detail Sesi</h3>
                            <dl class="mt-4 space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <dt class="text-text-muted">Topik</dt>
                                    <dd class="font-semibold text-text">{{ $session->topic }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-text-muted">Status</dt>
                                    <dd>
                                        <span class="{{ $statusVariant }}">{{ $session->status }}</span>
                                    </dd>
                                </div>
                                @if ($session->booking)
                                    <div class="flex justify-between">
                                        <dt class="text-text-muted">Booking</dt>
                                        <dd class="font-semibold text-text">{{ $session->booking->code }}</dd>
                                    </div>
                                @endif
                                <div class="flex justify-between">
                                    <dt class="text-text-muted">Dibuat</dt>
                                    <dd class="font-semibold text-text">{{ $session->created_at->format('d M Y H:i') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        const messages = document.getElementById('messages');
        if (messages) {
            messages.scrollTop = messages.scrollHeight;
        }
    </script>
    @endpush
@endsection
