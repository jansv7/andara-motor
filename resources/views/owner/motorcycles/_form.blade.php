@php
    $isEdit = isset($motorcycle);
    $currentYear = (int) date('Y');
@endphp

@if ($errors->any())
    <div role="alert" class="mb-6 rounded-md border border-red-200 bg-red-50 p-4 text-sm text-red-900">
        <p class="font-bold">Periksa kembali data yang Anda masukkan:</p>
        <ul class="mt-1.5 list-disc space-y-1 pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-8">
    {{-- 1. Identitas & Spesifikasi Dasar --}}
    <fieldset class="rounded-lg border border-line bg-white p-5 sm:p-6">
        <legend class="px-1 text-base font-bold text-ink">1. Identitas &amp; Spesifikasi Motor</legend>
        <p class="mt-1 text-xs text-muted">Data utama yang tampil di kartu katalog dan halaman detail pembeli.</p>

        <div class="mt-5 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div>
                <label for="brand_id" class="block text-sm font-semibold text-ink">
                    Merek <span class="text-brand" aria-hidden="true">*</span>
                </label>
                <select
                    id="brand_id"
                    name="brand_id"
                    required
                    @error('brand_id') aria-invalid="true" aria-describedby="brand_id-error" @enderror
                    class="mt-1.5 w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-ink focus:border-brand"
                >
                    <option value="">Pilih Merek</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" @selected(old('brand_id', $motorcycle->brand_id ?? '') == $brand->id)>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
                @error('brand_id')
                    <p id="brand_id-error" class="mt-1 text-xs font-medium text-brand">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="model" class="block text-sm font-semibold text-ink">
                    Model / Tipe <span class="text-brand" aria-hidden="true">*</span>
                </label>
                <input
                    id="model"
                    name="model"
                    type="text"
                    value="{{ old('model', $motorcycle->model ?? '') }}"
                    required
                    maxlength="100"
                    placeholder="Contoh: Vario 160 CBS"
                    @error('model') aria-invalid="true" aria-describedby="model-error" @enderror
                    class="mt-1.5 w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-ink focus:border-brand"
                >
                @error('model')
                    <p id="model-error" class="mt-1 text-xs font-medium text-brand">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category" class="block text-sm font-semibold text-ink">
                    Kategori <span class="text-brand" aria-hidden="true">*</span>
                </label>
                <select
                    id="category"
                    name="category"
                    required
                    @error('category') aria-invalid="true" aria-describedby="category-error" @enderror
                    class="mt-1.5 w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-ink focus:border-brand"
                >
                    @foreach (['matic' => 'Matic', 'bebek' => 'Bebek', 'sport' => 'Sport', 'trail' => 'Trail', 'lainnya' => 'Lainnya'] as $val => $label)
                        <option value="{{ $val }}" @selected(old('category', $motorcycle->category ?? 'matic') === $val)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('category')
                    <p id="category-error" class="mt-1 text-xs font-medium text-brand">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="year" class="block text-sm font-semibold text-ink">
                    Tahun Pembuatan <span class="text-brand" aria-hidden="true">*</span>
                </label>
                <input
                    id="year"
                    name="year"
                    type="number"
                    inputmode="numeric"
                    min="1990"
                    max="{{ $currentYear }}"
                    value="{{ old('year', $motorcycle->year ?? $currentYear) }}"
                    required
                    @error('year') aria-invalid="true" aria-describedby="year-error" @enderror
                    class="mt-1.5 block w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-ink tabular-nums focus:border-brand"
                >
                @error('year')
                    <p id="year-error" class="mt-1 text-xs font-medium text-brand">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="color" class="block text-sm font-semibold text-ink">
                    Warna <span class="text-brand" aria-hidden="true">*</span>
                </label>
                <input
                    id="color"
                    name="color"
                    type="text"
                    value="{{ old('color', $motorcycle->color ?? '') }}"
                    required
                    maxlength="30"
                    placeholder="Contoh: Hitam Doff"
                    @error('color') aria-invalid="true" aria-describedby="color-error" @enderror
                    class="mt-1.5 w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-ink focus:border-brand"
                >
                @error('color')
                    <p id="color-error" class="mt-1 text-xs font-medium text-brand">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="engine_cc" class="block text-sm font-semibold text-ink">
                    Kapasitas Mesin (cc) <span class="text-brand" aria-hidden="true">*</span>
                </label>
                <input
                    id="engine_cc"
                    name="engine_cc"
                    type="number"
                    inputmode="numeric"
                    min="50"
                    max="2500"
                    value="{{ old('engine_cc', $motorcycle->engine_cc ?? 150) }}"
                    required
                    @error('engine_cc') aria-invalid="true" aria-describedby="engine_cc-error" @enderror
                    class="mt-1.5 block w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-ink tabular-nums focus:border-brand"
                >
                @error('engine_cc')
                    <p id="engine_cc-error" class="mt-1 text-xs font-medium text-brand">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="transmission" class="block text-sm font-semibold text-ink">
                    Transmisi <span class="text-brand" aria-hidden="true">*</span>
                </label>
                <select
                    id="transmission"
                    name="transmission"
                    required
                    class="mt-1.5 w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-ink focus:border-brand"
                >
                    @foreach (['matic' => 'Matic', 'manual' => 'Manual', 'kopling' => 'Kopling'] as $val => $label)
                        <option value="{{ $val }}" @selected(old('transmission', $motorcycle->transmission ?? 'matic') === $val)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="mileage" class="block text-sm font-semibold text-ink">
                    Jarak Tempuh (km) <span class="text-brand" aria-hidden="true">*</span>
                </label>
                <input
                    id="mileage"
                    name="mileage"
                    type="number"
                    inputmode="numeric"
                    min="0"
                    value="{{ old('mileage', $motorcycle->mileage ?? 0) }}"
                    required
                    @error('mileage') aria-invalid="true" aria-describedby="mileage-error" @enderror
                    class="mt-1.5 block w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-ink tabular-nums focus:border-brand"
                >
                @error('mileage')
                    <p id="mileage-error" class="mt-1 text-xs font-medium text-brand">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="plate_region" class="block text-sm font-semibold text-ink">
                    Kode Wilayah Plat
                </label>
                <input
                    id="plate_region"
                    name="plate_region"
                    type="text"
                    maxlength="5"
                    value="{{ old('plate_region', $motorcycle->plate_region ?? '') }}"
                    placeholder="Contoh: AB"
                    aria-describedby="plate-help"
                    class="mt-1.5 block w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 uppercase text-ink focus:border-brand"
                >
                <p id="plate-help" class="mt-1 text-xs text-muted">Isi kode wilayah saja (nomor plat lengkap tidak ditampilkan ke publik).</p>
            </div>
        </div>
    </fieldset>

    {{-- 2. Kondisi Mesin, Surat, Pajak & Garansi (Wawancara Q2) --}}
    <fieldset class="rounded-lg border border-line bg-white p-5 sm:p-6">
        <legend class="px-1 text-base font-bold text-ink">2. Kondisi Unit, Surat &amp; Garansi</legend>
        <p class="mt-1 text-xs text-muted">Menjawab pertanyaan yang paling sering diajukan pembeli sebelum menghubungi WhatsApp.</p>

        <div class="mt-5 grid gap-5 sm:grid-cols-2">
            <div>
                <label for="setting_condition" class="block text-sm font-semibold text-ink">
                    Kondisi Setting / Modifikasi <span class="text-brand" aria-hidden="true">*</span>
                </label>
                <select
                    id="setting_condition"
                    name="setting_condition"
                    required
                    class="mt-1.5 w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-ink focus:border-brand"
                >
                    @foreach (['standar' => 'Standar Pabrik', 'modifikasi_ringan' => 'Modifikasi Ringan', 'modifikasi_berat' => 'Modifikasi Berat'] as $val => $label)
                        <option value="{{ $val }}" @selected(old('setting_condition', $motorcycle->setting_condition ?? 'standar') === $val)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="modification_notes" class="block text-sm font-semibold text-ink">
                    Detail Modifikasi (Opsional)
                </label>
                <input
                    id="modification_notes"
                    name="modification_notes"
                    type="text"
                    value="{{ old('modification_notes', $motorcycle->modification_notes ?? '') }}"
                    placeholder="Contoh: Knalpot racing, velg aftermarket"
                    class="mt-1.5 w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-ink focus:border-brand"
                >
            </div>

            <div>
                <label for="tax_expired_at" class="block text-sm font-semibold text-ink">
                    Masa Berlaku Pajak
                </label>
                <input
                    id="tax_expired_at"
                    name="tax_expired_at"
                    type="date"
                    value="{{ old('tax_expired_at', isset($motorcycle) && $motorcycle->tax_expired_at ? $motorcycle->tax_expired_at->format('Y-m-d') : '') }}"
                    class="mt-1.5 w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-ink focus:border-brand"
                >
            </div>

            <div>
                <label for="warranty" class="block text-sm font-semibold text-ink">
                    Garansi Showroom
                </label>
                <input
                    id="warranty"
                    name="warranty"
                    type="text"
                    maxlength="100"
                    value="{{ old('warranty', $motorcycle->warranty ?? 'Garansi mesin 1 bulan') }}"
                    placeholder="Contoh: Garansi mesin 1 bulan"
                    class="mt-1.5 w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-ink focus:border-brand"
                >
            </div>
        </div>

        <div class="mt-5 grid gap-5 border-t border-line pt-5 sm:grid-cols-2">
            <div>
                <span class="block text-sm font-semibold text-ink">Kelengkapan Surat</span>
                <div class="mt-2.5 flex flex-wrap gap-5">
                    <div class="flex items-center gap-2">
                        <input id="has_bpkb" name="has_bpkb" type="checkbox" value="1" @checked(old('has_bpkb', $motorcycle->has_bpkb ?? true)) class="h-4 w-4 rounded border-slate-300 accent-brand">
                        <label for="has_bpkb" class="text-sm text-ink">BPKB</label>
                    </div>
                    <div class="flex items-center gap-2">
                        <input id="has_stnk" name="has_stnk" type="checkbox" value="1" @checked(old('has_stnk', $motorcycle->has_stnk ?? true)) class="h-4 w-4 rounded border-slate-300 accent-brand">
                        <label for="has_stnk" class="text-sm text-ink">STNK</label>
                    </div>
                    <div class="flex items-center gap-2">
                        <input id="has_faktur" name="has_faktur" type="checkbox" value="1" @checked(old('has_faktur', $motorcycle->has_faktur ?? false)) class="h-4 w-4 rounded border-slate-300 accent-brand">
                        <label for="has_faktur" class="text-sm text-ink">Faktur</label>
                    </div>
                </div>
            </div>

            <div>
                <span class="block text-sm font-semibold text-ink">Riwayat Bongkar Mesin</span>
                <div class="mt-2.5 flex items-center gap-2">
                    <input id="engine_ever_opened" name="engine_ever_opened" type="checkbox" value="1" @checked(old('engine_ever_opened', $motorcycle->engine_ever_opened ?? false)) class="h-4 w-4 rounded border-slate-300 accent-brand">
                    <label for="engine_ever_opened" class="text-sm text-ink">Pernah dibongkar / turun mesin</label>
                </div>
                <input
                    id="engine_notes"
                    name="engine_notes"
                    type="text"
                    value="{{ old('engine_notes', $motorcycle->engine_notes ?? '') }}"
                    aria-label="Keterangan riwayat bongkar mesin"
                    placeholder="Keterangan riwayat mesin jika pernah dibongkar"
                    class="mt-2.5 block w-full rounded-md border border-slate-300 bg-white px-3.5 py-2 text-sm text-ink focus:border-brand"
                >
            </div>
        </div>

        <div class="mt-5">
            <label for="description" class="block text-sm font-semibold text-ink">Deskripsi Tambahan</label>
            <textarea
                id="description"
                name="description"
                rows="3"
                placeholder="Ceritakan kondisi body, ban, servis terakhir, atau keunggulan unit ini."
                class="mt-1.5 w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-ink focus:border-brand"
            >{{ old('description', $motorcycle->description ?? '') }}</textarea>
        </div>
    </fieldset>

    {{-- 3. Harga & Data Pembelian Internal --}}
    <fieldset class="rounded-lg border border-line bg-white p-5 sm:p-6">
        <legend class="px-1 text-base font-bold text-ink">3. Harga Jual &amp; Data Pembelian (Internal Owner)</legend>
        <p class="mt-1 text-xs text-muted">Harga beli dan sumber pembelian bersifat rahasia dan hanya terlihat oleh Owner.</p>

        <div class="mt-5 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div>
                <label for="selling_price" class="block text-sm font-semibold text-ink">
                    Harga Jual Publik (Rp) <span class="text-brand" aria-hidden="true">*</span>
                </label>
                <input
                    id="selling_price"
                    name="selling_price"
                    type="number"
                    inputmode="numeric"
                    min="0"
                    step="50000"
                    value="{{ old('selling_price', $motorcycle->selling_price ?? '') }}"
                    required
                    placeholder="17500000"
                    @error('selling_price') aria-invalid="true" aria-describedby="selling_price-error" @enderror
                    class="mt-1.5 block w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 font-semibold text-ink tabular-nums focus:border-brand"
                >
                @error('selling_price')
                    <p id="selling_price-error" class="mt-1 text-xs font-medium text-brand">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="purchase_price" class="block text-sm font-semibold text-ink">
                    Harga Beli Modal (Rp) <span class="text-brand" aria-hidden="true">*</span>
                </label>
                <input
                    id="purchase_price"
                    name="purchase_price"
                    type="number"
                    inputmode="numeric"
                    min="0"
                    step="50000"
                    value="{{ old('purchase_price', $motorcycle->purchase_price ?? '') }}"
                    required
                    placeholder="15000000"
                    @error('purchase_price') aria-invalid="true" aria-describedby="purchase_price-error" @enderror
                    class="mt-1.5 block w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-ink tabular-nums focus:border-brand"
                >
                @error('purchase_price')
                    <p id="purchase_price-error" class="mt-1 text-xs font-medium text-brand">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="purchase_date" class="block text-sm font-semibold text-ink">
                    Tanggal Pembelian <span class="text-brand" aria-hidden="true">*</span>
                </label>
                <input
                    id="purchase_date"
                    name="purchase_date"
                    type="date"
                    max="{{ date('Y-m-d') }}"
                    value="{{ old('purchase_date', isset($motorcycle) && $motorcycle->purchase_date ? $motorcycle->purchase_date->format('Y-m-d') : date('Y-m-d')) }}"
                    required
                    @error('purchase_date') aria-invalid="true" aria-describedby="purchase_date-error" @enderror
                    class="mt-1.5 w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-ink focus:border-brand"
                >
                @error('purchase_date')
                    <p id="purchase_date-error" class="mt-1 text-xs font-medium text-brand">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-2 lg:col-span-3">
                <label for="purchase_source" class="block text-sm font-semibold text-ink">
                    Sumber / Penjual Sebelumnya (Opsional)
                </label>
                <input
                    id="purchase_source"
                    name="purchase_source"
                    type="text"
                    maxlength="100"
                    value="{{ old('purchase_source', $motorcycle->purchase_source ?? '') }}"
                    placeholder="Contoh: Perorangan, Tukar Tambah, Lelang"
                    class="mt-1.5 w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-ink focus:border-brand"
                >
            </div>
        </div>

        <div class="mt-5 flex flex-wrap gap-6 border-t border-line pt-4">
            <div class="flex items-center gap-2">
                <input id="is_negotiable" name="is_negotiable" type="checkbox" value="1" @checked(old('is_negotiable', $motorcycle->is_negotiable ?? true)) class="h-4 w-4 rounded border-slate-300 accent-brand">
                <label for="is_negotiable" class="text-sm font-medium text-ink">Harga bisa nego</label>
            </div>
            <div class="flex items-center gap-2">
                <input id="is_featured" name="is_featured" type="checkbox" value="1" @checked(old('is_featured', $motorcycle->is_featured ?? false)) class="h-4 w-4 rounded border-slate-300 accent-brand">
                <label for="is_featured" class="text-sm font-medium text-ink">Tampilkan sebagai Unit Unggulan di Beranda</label>
            </div>
        </div>
    </fieldset>

    {{-- 4. Foto Utama Unit --}}
    <fieldset class="rounded-lg border border-line bg-white p-5 sm:p-6">
        <legend class="px-1 text-base font-bold text-ink">4. Foto Utama Unit</legend>
        <p class="mt-1 text-xs text-muted">Format JPG, PNG, atau WebP, ukuran maksimal 2 MB.</p>

        <div class="mt-4 space-y-4">
            @if ($isEdit && $motorcycle->primaryPhotoUrl())
                <div class="flex items-center gap-4">
                    <img
                        src="{{ $motorcycle->primaryPhotoUrl() }}"
                        alt="{{ $motorcycle->fullName() }}"
                        width="160"
                        height="120"
                        class="h-24 w-32 rounded-md border border-line object-cover"
                    >
                    <p class="text-xs text-muted">Foto utama saat ini. Pilih file baru di bawah jika ingin menggantinya.</p>
                </div>
            @endif

            <div>
                <label for="photo" class="block text-sm font-semibold text-ink">
                    Unggah Foto {{ $isEdit ? 'Pengganti (Opsional)' : 'Utama' }}
                </label>
                <input
                    id="photo"
                    name="photo"
                    type="file"
                    accept="image/jpeg,image/png,image/webp"
                    @error('photo') aria-invalid="true" aria-describedby="photo-error" @enderror
                    class="mt-1.5 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-ink file:mr-4 file:rounded file:border-0 file:bg-ink file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white hover:file:bg-ink-soft"
                >
                @error('photo')
                    <p id="photo-error" class="mt-1 text-xs font-medium text-brand">{{ $message }}</p>
                @enderror
            </div>

            <div id="photo-preview-box" hidden class="pt-1">
                <p class="mb-2 text-xs font-semibold text-muted">Pratinjau foto baru:</p>
                <img id="photo-preview-img" src="" alt="Pratinjau foto unit baru" width="240" height="180" class="h-36 w-48 rounded-md border border-line object-cover">
            </div>
        </div>
    </fieldset>
</div>
