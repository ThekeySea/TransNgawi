<x-ui.input
    label="Nomor Pelat"
    name="plate_number"
    :value="old('plate_number', $bus->plate_number ?? '')"
    :error="$errors->first('plate_number')"
    placeholder="mis. N 1234 AB"
    required
/>

<div class="mt-5">
    <x-ui.select label="Model Bus (Template Kursi)" name="model_type" :error="$errors->first('model_type')" required>
        <option value="">— Pilih model —</option>
        @foreach ($modelTypes as $type)
            <option value="{{ $type->value }}" @selected(old('model_type', ($bus->model_type ?? null)?->value) === $type->value)>{{ $type->label() }}</option>
        @endforeach
    </x-ui.select>
    <p class="mt-1.5 text-sm text-[#555555]">BIASANE tanpa SukianPro; ANTIBU/SATSET mendukung semua kelas.</p>
</div>

<div class="mt-5">
    <x-ui.input
        label="Status"
        name="status"
        :value="old('status', $bus->status ?? 'IDLE')"
        :error="$errors->first('status')"
        hint="Status operasional bus (mis. IDLE)."
        required
    />
</div>
