<x-ui.input
    label="Nomor Pelat"
    name="plate_number"
    :value="old('plate_number', $bus->plate_number ?? '')"
    :error="$errors->first('plate_number')"
    placeholder="mis. N 1234 AB"
    required
/>

@php
    $pletonSeats = collect(\App\Support\BusSeatTemplate::seats(\App\Enums\BusModelType::PLETON))
        ->map(fn($s) => ['id' => $s['seat_code'], 'class' => $s['class_name']])
        ->toArray();
    $ksatriaSeats = collect(\App\Support\BusSeatTemplate::seats(\App\Enums\BusModelType::KSATRIA))
        ->map(fn($s) => ['id' => $s['seat_code'], 'class' => $s['class_name']])
        ->toArray();
@endphp

<div class="mt-5" x-data="{ selectedModel: '{{ old('model_type', ($bus->model_type ?? null)?->value ?? '') }}' }">
    <x-ui.select label="Model Bus (Template Kursi)" name="model_type" :error="$errors->first('model_type')" required x-model="selectedModel">
        <option value="">— Pilih model —</option>
        @foreach ($modelTypes as $type)
            <option value="{{ $type->value }}" @selected(old('model_type', ($bus->model_type ?? null)?->value) === $type->value)>{{ $type->label() }}</option>
        @endforeach
    </x-ui.select>
    <p class="mt-1.5 text-sm text-[#555555]">Pleton: 40 kursi (Sukian + SukianPlus). Ksatria: 30 kursi (Sukian + SukianPlus + SukianPro).</p>

    {{-- Live Layout Preview --}}
    <div x-show="selectedModel !== ''" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="mt-4">
        <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-[#555555]">Preview Layout Kursi</p>
        <div class="rounded-xl border border-[#e6e6e6] bg-[#faf9f8] p-4">
            {{-- PLETON Preview --}}
            <div x-show="selectedModel === 'PLETON' || selectedModel === 'BIASANE'">
                <x-booking.seat-map
                    :seats="$pletonSeats"
                    :occupied="[]"
                    :maxSeats="0"
                    busModel="PLETON"
                    :preview="true"
                />
            </div>
            {{-- KSATRIA Preview --}}
            <div x-show="selectedModel === 'KSATRIA' || selectedModel === 'ANTIBU_SATSET'">
                <x-booking.seat-map
                    :seats="$ksatriaSeats"
                    :occupied="[]"
                    :maxSeats="0"
                    busModel="KSATRIA"
                    :preview="true"
                />
            </div>
        </div>
    </div>
</div>

<div class="mt-5">
    <x-ui.select label="Status" name="status" :error="$errors->first('status')" required>
        <option value="">— Pilih status —</option>
        @foreach (\App\Enums\BusStatus::cases() as $status)
            <option value="{{ $status->value }}" @selected(old('status', ($bus->status ?? null)?->value) === $status->value)>{{ $status->label() }}</option>
        @endforeach
    </x-ui.select>
    <p class="mt-1.5 text-sm text-[#555555]">Bus hanya bisa ditugaskan ke trip baru saat status Tersedia (IDLE).</p>
</div>
