@php
    $currentOrigin = old('origin_id', $route->origin_id ?? '');
    $currentDestination = old('destination_id', $route->destination_id ?? '');
    $currentService = old('service_category', $route->service_category?->value ?? '');
@endphp

<div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
    <x-ui.select label="Kota Asal" name="origin_id" :error="$errors->first('origin_id')" required>
        <option value="">— Pilih kota asal —</option>
        @foreach ($locations as $loc)
            <option value="{{ $loc->id }}" @selected((int) $currentOrigin === $loc->id)>{{ $loc->name }} @if($loc->is_capital) (Ibu Kota) @endif @if($loc->is_important) (Penting) @endif</option>
        @endforeach
    </x-ui.select>

    <x-ui.select label="Kota Tujuan" name="destination_id" :error="$errors->first('destination_id')" required>
        <option value="">— Pilih kota tujuan —</option>
        @foreach ($locations as $loc)
            <option value="{{ $loc->id }}" @selected((int) $currentDestination === $loc->id)>{{ $loc->name }} @if($loc->is_capital) (Ibu Kota) @endif @if($loc->is_important) (Penting) @endif</option>
        @endforeach
    </x-ui.select>
</div>

<div class="mt-5">
    <p class="input-label">Kategori Layanan</p>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3" x-data="{ picked: '{{ $currentService }}' }">
        @foreach ($services as $service)
            <label class="cursor-pointer rounded-[var(--radius-sm)] border p-4 transition-all" :class="picked === '{{ $service->value }}' ? 'border-[#ff750f] bg-[#ff750f]/5' : 'border-[#e6e6e6]'">
                <input type="radio" name="service_category" value="{{ $service->value }}" x-model="picked" class="h-4 w-4" style="accent-color: #ff750f">
                <span class="mt-2 block text-sm font-bold">{{ $service->name }}</span>
                <span class="block text-xs text-[#555555]">{{ $service->label() }}</span>
            </label>
        @endforeach
    </div>
    @error('service_category')
        <p class="mt-1.5 text-sm text-red-600" role="alert">{{ $message }}</p>
    @enderror
    @error('origin_id')
        <p class="mt-1.5 text-sm text-red-600" role="alert">{{ $message }}</p>
    @enderror
</div>
