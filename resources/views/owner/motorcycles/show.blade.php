@extends('layouts.owner')

@section('title', 'Detail Unit '.$motorcycle->code)
@section('page_title', $motorcycle->fullName().' ('.$motorcycle->code.')')

@section('header_actions')
    <a href="{{ route('owner.motorcycles.edit', $motorcycle) }}" class="btn-primary text-sm">
        Edit Unit
    </a>
@endsection

@section('content')
    @php
        $totalReconditioning = (int) $motorcycle->reconditioningCosts->sum('amount');
        $estimatedProfit = (int) $motorcycle->selling_price - (int) $motorcycle->purchase_price - $totalReconditioning;
    @endphp

    <div class="grid gap-6 lg:grid-cols-12">
        <div class="space-y-6 lg:col-span-7">
            <div class="overflow-hidden rounded-lg border border-line bg-white">
                <div class="aspect-[4/3] w-full bg-surface">
                    @if ($motorcycle->primaryPhotoUrl())
                        <img
                            src="{{ $motorcycle->primaryPhotoUrl() }}"
                            alt="{{ $motorcycle->fullName() }}"
                            width="800"
                            height="600"
                            class="h-full w-full object-cover"
                        >
                    @else
                        <div class="flex h-full items-center justify-center text-sm text-muted">
                            Belum ada foto untuk unit ini.
                        </div>
                    @endif
                </div>
                <div class="flex flex-wrap items-center justify-between gap-3 border-t border-line px-5 py-4">
                    <div class="flex items-center gap-2.5">
                        <x-status-badge :status="$motorcycle->status" />
                        <span class="text-xs font-semibold text-muted tabular-nums">Kode: {{ $motorcycle->code }}</span>
                    </div>
                    <a href="{{ route('catalog.show', $motorcycle->slug) }}" target="_blank" rel="noopener noreferrer" class="text-sm font-semibold text-brand hover:underline">
                        Buka halaman publik
                    </a>
                </div>
            </div>

            <div class="rounded-lg border border-line bg-white p-5">
                <h2 class="text-base font-bold text-ink">Spesifikasi &amp; Kondisi</h2>
                <dl class="mt-4 grid gap-3 text-sm sm:grid-cols-2">
                    <div class="border-b border-line pb-2.5">
                        <dt class="text-xs font-semibold text-muted">Merek &amp; Model</dt>
                        <dd class="mt-0.5 font-semibold text-ink">{{ $motorcycle->fullName() }}</dd>
                    </div>
                    <div class="border-b border-line pb-2.5">
                        <dt class="text-xs font-semibold text-muted">Kategori &amp; Transmisi</dt>
                        <dd class="mt-0.5 font-semibold text-ink">{{ $motorcycle->categoryLabel() }} / {{ $motorcycle->transmissionLabel() }}</dd>
                    </div>
                    <div class="border-b border-line pb-2.5">
                        <dt class="text-xs font-semibold text-muted">Tahun &amp; Warna</dt>
                        <dd class="mt-0.5 font-semibold text-ink tabular-nums">{{ $motorcycle->year }} / {{ $motorcycle->color }}</dd>
                    </div>
                    <div class="border-b border-line pb-2.5">
                        <dt class="text-xs font-semibold text-muted">Mesin &amp; Odometer</dt>
                        <dd class="mt-0.5 font-semibold text-ink tabular-nums">{{ $motorcycle->engine_cc }} cc / {{ $motorcycle->formattedMileage() }}</dd>
                    </div>
                    <div class="border-b border-line pb-2.5">
                        <dt class="text-xs font-semibold text-muted">Kondisi Setting</dt>
                        <dd class="mt-0.5 font-semibold text-ink">{{ $motorcycle->settingConditionLabel() }}</dd>
                    </div>
                    <div class="border-b border-line pb-2.5">
                        <dt class="text-xs font-semibold text-muted">Riwayat Bongkar Mesin</dt>
                        <dd class="mt-0.5 font-semibold text-ink">{{ $motorcycle->engine_ever_opened ? 'Pernah dibongkar' : 'Belum pernah dibongkar' }}</dd>
                    </div>
                    <div class="border-b border-line pb-2.5">
                        <dt class="text-xs font-semibold text-muted">Kelengkapan Surat</dt>
                        <dd class="mt-0.5 font-semibold text-ink">
                            BPKB: {{ $motorcycle->has_bpkb ? 'Ada' : 'Tidak' }} &middot;
                            STNK: {{ $motorcycle->has_stnk ? 'Ada' : 'Tidak' }} &middot;
                            Faktur: {{ $motorcycle->has_faktur ? 'Ada' : 'Tidak' }}
                        </dd>
                    </div>
                    <div class="border-b border-line pb-2.5">
                        <dt class="text-xs font-semibold text-muted">Status Pajak</dt>
                        <dd class="mt-0.5 font-semibold text-ink">{{ $motorcycle->taxLabel() }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-xs font-semibold text-muted">Garansi &amp; Catatan</dt>
                        <dd class="mt-1 text-ink">{{ $motorcycle->warranty ?: 'Tidak ada garansi khusus' }}</dd>
                        @if ($motorcycle->description)
                            <p class="mt-2 leading-relaxed text-muted">{{ $motorcycle->description }}</p>
                        @endif
                    </div>
                </dl>
            </div>
        </div>

        <div class="space-y-6 lg:col-span-5">
            <div class="rounded-lg border border-line bg-white p-5">
                <h2 class="text-base font-bold text-ink">Ringkasan Modal &amp; Estimasi Profit</h2>
                <p class="mt-1 text-xs text-muted">Khusus internal Owner, tidak pernah tampil ke pengunjung publik.</p>

                <dl class="mt-4 space-y-3 text-sm">
                    <div class="flex items-center justify-between border-b border-line pb-2.5">
                        <dt class="text-muted">Harga Jual Publik</dt>
                        <dd class="text-base font-extrabold text-ink tabular-nums">{{ $motorcycle->formattedSellingPrice() }}</dd>
                    </div>
                    <div class="flex items-center justify-between border-b border-line pb-2.5">
                        <dt class="text-muted">Harga Beli Modal</dt>
                        <dd class="font-semibold text-ink tabular-nums">{{ $motorcycle->formattedPurchasePrice() }}</dd>
                    </div>
                    <div class="flex items-center justify-between border-b border-line pb-2.5">
                        <dt class="text-muted">Total Biaya Rekondisi</dt>
                        <dd class="font-semibold text-ink tabular-nums">Rp {{ number_format($totalReconditioning, 0, ',', '.') }}</dd>
                    </div>
                    <div class="flex items-center justify-between rounded-md bg-surface px-3 py-2.5">
                        <dt class="font-semibold text-ink">Estimasi Keuntungan</dt>
                        <dd class="text-base font-extrabold tabular-nums {{ $estimatedProfit >= 0 ? 'text-emerald-700' : 'text-brand' }}">
                            Rp {{ number_format($estimatedProfit, 0, ',', '.') }}
                        </dd>
                    </div>
                </dl>

                <div class="mt-4 space-y-1.5 border-t border-line pt-4 text-xs text-muted">
                    <p><span class="font-semibold text-ink">Tanggal Beli:</span> {{ $motorcycle->purchase_date?->locale('id')->translatedFormat('d F Y') }}</p>
                    <p><span class="font-semibold text-ink">Sumber Unit:</span> {{ $motorcycle->purchase_source ?: 'Belum dicatat' }}</p>
                </div>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('owner.motorcycles.index') }}" class="btn-secondary flex-1 text-sm">
                    Kembali ke Daftar
                </a>
                <a href="{{ route('owner.motorcycles.edit', $motorcycle) }}" class="btn-dark flex-1 text-sm">
                    Edit Unit Ini
                </a>
            </div>
        </div>
    </div>
@endsection
