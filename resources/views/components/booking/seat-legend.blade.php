@props(['busModel' => 'PLETON'])

@php
    $resolvedModel = in_array($busModel, ['BIASANE', 'ANTIBU_SATSET'])
        ? ($busModel === 'BIASANE' ? 'PLETON' : 'KSATRIA')
        : $busModel;
    $isKsatria = $resolvedModel === 'KSATRIA';
@endphp

<div class="seat-legend">
    <div class="seat-legend-header">
        <h3 class="text-sm font-bold text-[#1a1a1a]">Kenali Tipe Kursi Anda</h3>
    </div>

    {{-- Sukian --}}
    <div class="seat-legend-row">
        <div class="seat-legend-icon">
            <svg viewBox="0 0 32 32" fill="none">
                <rect x="3" y="2" width="26" height="12" rx="4" fill="#34D399"/>
                <rect x="5" y="14" width="22" height="8" rx="3" fill="#34D399"/>
                <rect x="2" y="14" width="4" height="10" rx="2" fill="#059669"/>
                <rect x="26" y="14" width="4" height="10" rx="2" fill="#059669"/>
                <rect x="8" y="22" width="4" height="6" rx="1.5" fill="#059669"/>
                <rect x="20" y="22" width="4" height="6" rx="1.5" fill="#059669"/>
            </svg>
        </div>
        <div class="seat-legend-info">
            <p class="seat-legend-name">Sukian</p>
            <div class="seat-legend-features">
                <span class="seat-legend-feature">Kursi Standar</span>
                <span class="seat-legend-feature">Snack Gratis</span>
                <span class="seat-legend-feature">Air Mineral</span>
            </div>
        </div>
    </div>

    {{-- SukianPlus --}}
    <div class="seat-legend-row">
        <div class="seat-legend-icon">
            <svg viewBox="0 0 32 32" fill="none">
                <rect x="3" y="2" width="26" height="12" rx="4" fill="#60A5FA"/>
                <rect x="5" y="14" width="22" height="8" rx="3" fill="#60A5FA"/>
                <rect x="2" y="14" width="4" height="10" rx="2" fill="#2563EB"/>
                <rect x="26" y="14" width="4" height="10" rx="2" fill="#2563EB"/>
                <rect x="8" y="22" width="4" height="6" rx="1.5" fill="#2563EB"/>
                <rect x="20" y="22" width="4" height="6" rx="1.5" fill="#2563EB"/>
            </svg>
        </div>
        <div class="seat-legend-info">
            <p class="seat-legend-name">SukianPlus</p>
            <div class="seat-legend-features">
                <span class="seat-legend-feature">Kursi Lebih Luas</span>
                <span class="seat-legend-feature">Sandaran Kaki</span>
                <span class="seat-legend-feature">Snack & Minuman</span>
                <span class="seat-legend-feature">Souvenir</span>
            </div>
        </div>
    </div>

    {{-- SukianPro (KSATRIA only) --}}
    @if ($isKsatria)
        <div class="seat-legend-row">
            <div class="seat-legend-icon">
                <svg viewBox="0 0 28 36" fill="none">
                    <rect x="2" y="2" width="24" height="32" rx="5" fill="#A78BFA"/>
                    <rect x="5" y="5" width="18" height="10" rx="3" fill="#C4B5FD"/>
                    <rect x="5" y="20" width="18" height="8" rx="3" fill="#C4B5FD"/>
                </svg>
            </div>
            <div class="seat-legend-info">
                <p class="seat-legend-name">SukianPro</p>
                <div class="seat-legend-features">
                    <span class="seat-legend-feature">Kabin Tidur</span>
                    <span class="seat-legend-feature">TV Pribadi</span>
                    <span class="seat-legend-feature">Privasi Penuh</span>
                </div>
            </div>
        </div>
    @endif

    {{-- Occupied Example --}}
    <div class="seat-legend-row">
        <div class="seat-legend-icon">
            <svg viewBox="0 0 32 32" fill="none">
                <rect x="3" y="2" width="26" height="12" rx="4" fill="#D1D5DB"/>
                <rect x="5" y="14" width="22" height="8" rx="3" fill="#D1D5DB"/>
                <rect x="2" y="14" width="4" height="10" rx="2" fill="#B8BAB8"/>
                <rect x="26" y="14" width="4" height="10" rx="2" fill="#B8BAB8"/>
                <rect x="8" y="22" width="4" height="6" rx="1.5" fill="#B8BAB8"/>
                <rect x="20" y="22" width="4" height="6" rx="1.5" fill="#B8BAB8"/>
            </svg>
        </div>
        <div class="seat-legend-info">
            <p class="seat-legend-name">Sudah Dipesan</p>
            <div class="seat-legend-features">
                <span class="seat-legend-feature">Tidak Tersedia</span>
            </div>
        </div>
    </div>
</div>
