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

<div class="mt-8" x-data="stopPointsForm()">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-bold text-[#1a1a1a]">Titik Pemberhentian</p>
            <p class="text-xs text-[#555555]">Kelola terminal atau halte di kota ini.</p>
        </div>
        <button type="button" @click="add()" class="btn-secondary px-3 py-1.5 text-xs">
            + Tambah
        </button>
    </div>

    <div class="mt-4 space-y-4">
        <template x-for="(point, index) in points" :key="index">
            <div class="rounded-lg border border-[#e6e6e6] p-4">
                <input type="hidden" :name="'stop_points[' + index + '][id]'" :value="point.id || ''">
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                    <div>
                        <label class="block text-xs font-semibold text-[#555555]">Nama</label>
                        <input type="text" :name="'stop_points[' + index + '][name]'" x-model="point.name" placeholder="mis. Terminal Purabaya" class="mt-1 w-full rounded-lg border border-[#e6e6e6] px-3 py-2 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-[#555555]">Alamat (opsional)</label>
                        <input type="text" :name="'stop_points[' + index + '][address]'" x-model="point.address" placeholder="mis. Jl. Ahmad Yani" class="mt-1 w-full rounded-lg border border-[#e6e6e6] px-3 py-2 text-sm">
                    </div>
                </div>
                <div class="mt-3 flex items-center justify-between">
                    <label class="flex cursor-pointer items-center gap-2" x-show="isImportantLocation">
                        <input type="checkbox" :name="'stop_points[' + index + '][is_important_point]'" value="1" :checked="point.is_important_point == 1" @change="point.is_important_point = $el.checked ? 1 : 0" class="h-4 w-4 accent-[#ff750f]">
                        <span class="text-xs font-semibold text-[#555555]">Tempat Penting (Bandara/Pelabuhan)</span>
                    </label>
                    <button type="button" @click="remove(index)" class="text-xs text-red-500 hover:text-red-700">Hapus</button>
                </div>
            </div>
        </template>

        <p x-show="points.length === 0" class="text-sm text-[#555555]">Belum ada titik pemberhentian. Klik "Tambah" untuk menambahkan.</p>
    </div>
</div>

<script>
function stopPointsForm() {
    return {
        isImportantLocation: @js(old('is_important', $location->is_important ?? false)),
        points: @js(old('stop_points', ($location->stopPoints ?? collect())->map(fn($sp) => [
            'id' => $sp->id,
            'name' => $sp->name,
            'address' => $sp->address,
            'is_important_point' => $sp->is_important_point ? 1 : 0,
        ])->toArray())),
        add() {
            this.points.push({ id: null, name: '', address: '', is_important_point: 0 });
        },
        remove(index) {
            this.points.splice(index, 1);
        },
        init() {
            this.$watch('$root.querySelector(\'[name=is_important]\')', (el) => {
                if (el) {
                    this.isImportantLocation = el.checked;
                    el.addEventListener('change', () => {
                        this.isImportantLocation = el.checked;
                        if (!el.checked) {
                            this.points.forEach(p => p.is_important_point = 0);
                        }
                    });
                }
            });
            // Initialize from checkbox state
            const checkbox = this.$root.querySelector('[name=is_important]');
            if (checkbox) {
                this.isImportantLocation = checkbox.checked;
                checkbox.addEventListener('change', () => {
                    this.isImportantLocation = checkbox.checked;
                    if (!checkbox.checked) {
                        this.points.forEach(p => p.is_important_point = 0);
                    }
                });
            }
        }
    }
}
</script>
