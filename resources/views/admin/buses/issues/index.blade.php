@extends('layouts.admin')

@section('title', 'Masalah Bus - '.$bus->plate_number)

@section('content')
    <div class="container-app">
        <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
            <div class="max-w-2xl">
                <h1 class="text-3xl font-bold tracking-tight">Masalah Bus</h1>
                <p class="mt-2 text-base text-[#555555]">{{ $bus->plate_number }} &middot; {{ $bus->model_type->label() }} &middot; Status: {{ $bus->status->label() }}</p>
            </div>
            <a href="{{ route('admin.buses.issues.create', $bus) }}" class="btn-primary">Laporkan Masalah</a>
        </div>

        <div class="card overflow-hidden">
            @if ($issues->isEmpty())
                <p class="p-6 text-sm text-[#555555] md:p-8">Belum ada laporan masalah untuk bus ini.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[640px] text-left text-sm">
                        <thead>
                            <tr class="border-b border-[#e6e6e6] text-xs uppercase tracking-wider text-[#555555]">
                                <th class="px-6 py-3 font-semibold">Kategori</th>
                                <th class="px-6 py-3 font-semibold">Deskripsi</th>
                                <th class="px-6 py-3 font-semibold">Tingkat</th>
                                <th class="px-6 py-3 font-semibold">Status</th>
                                <th class="px-6 py-3 text-right font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($issues as $issue)
                                <tr class="border-b border-[#e6e6e6] last:border-0">
                                    <td class="px-6 py-3 font-semibold">{{ $issue->category }}</td>
                                    <td class="px-6 py-3 text-[#555555]">{{ Str::limit($issue->description, 60) }}</td>
                                    <td class="px-6 py-3">
                                        @php
                                            $severityColor = match($issue->severity) {
                                                \App\Enums\IssueSeverity::LOW => 'green',
                                                \App\Enums\IssueSeverity::MEDIUM => 'blue',
                                                \App\Enums\IssueSeverity::HIGH => 'amber',
                                                \App\Enums\IssueSeverity::CRITICAL => 'red',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold bg-{{ $severityColor }}-100 text-{{ $severityColor }}-700">
                                            {{ $issue->severity->label() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3">
                                        @php
                                            $statusColor = match($issue->status) {
                                                \App\Enums\IssueStatus::OPEN => 'red',
                                                \App\Enums\IssueStatus::IN_PROGRESS => 'blue',
                                                \App\Enums\IssueStatus::RESOLVED => 'green',
                                                \App\Enums\IssueStatus::CLOSED => 'gray',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold bg-{{ $statusColor }}-100 text-{{ $statusColor }}-700">
                                            {{ $issue->status->label() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3">
                                        <div class="flex justify-end gap-2">
                                            <form method="POST" action="{{ route('admin.buses.issues.update-status', [$bus, $issue]) }}" class="inline-flex">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" onchange="this.form.submit()" class="rounded-[var(--radius-sm)] border border-[#e6e6e6] bg-white px-2 py-1 text-xs font-semibold focus:border-[#ff750f] focus:outline-none focus:ring-2 focus:ring-[#ff750f]/20">
                                                    @foreach (\App\Enums\IssueStatus::cases() as $status)
                                                        <option value="{{ $status->value }}" @selected($issue->status === $status)>{{ $status->label() }}</option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="border-t border-[#e6e6e6] px-6 py-4">
                    {{ $issues->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
