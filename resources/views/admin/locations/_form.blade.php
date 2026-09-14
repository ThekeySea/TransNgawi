<x-ui.input
    label="Nama Lokasi"
    name="name"
    :value="old('name', $location->name ?? '')"
    :error="$errors->first('name')"
    placeholder="mis. Surabaya"
    required
/>

<div class="mt-5 space-y-3">
    <label class="flex cursor-pointer items-start gap-3">
        <input type="checkbox" name="is_capital" value="1" @checked(old('is_capital', $location->is_capital ?? false)) class="mt-1 h-4 w-4 accent-[#ff750f]">
        <span>
            <span class="block text-sm font-semibold">Ibu kota</span>
            <span class="block text-sm text-[#555555]">Syarat rute ANTIBU: kedua kota harus ibu kota.</span>
        </span>
    </label>
    <label class="flex cursor-pointer items-start gap-3">
        <input type="checkbox" name="is_important" value="1" @checked(old('is_important', $location->is_important ?? false)) class="mt-1 h-4 w-4 accent-[#ff750f]">
        <span>
            <span class="block text-sm font-semibold">Tempat penting</span>
            <span class="block text-sm text-[#555555]">Syarat rute SATSET: kedua titik harus tempat penting.</span>
        </span>
    </label>
</div>
