@extends('layouts.public')

@section('title', $motorcycle->fullName().' '.$motorcycle->year.' Bekas | '.$store['store_name'])
@section('meta_description', $motorcycle->fullName().' tahun '.$motorcycle->year.', '.$motorcycle->formattedMileage().', harga '.$motorcycle->formattedSellingPrice().' di '.$store['store_name'].'.')
@section('body_class', 'pb-20 md:pb-0')

@section('meta_tags')
    <meta property="og:title" content="{{ $motorcycle->fullName() }} {{ $motorcycle->year }} - {{ $motorcycle->formattedSellingPrice() }}">
    <meta property="og:description" content="{{ $motorcycle->formattedMileage() }} | {{ $motorcycle->taxLabel() }} | {{ $store['store_name'] }}">
    <meta property="og:type" content="product">
    @if ($motorcycle->primaryPhotoUrl())
        <meta property="og:image" content="{{ $motorcycle->primaryPhotoUrl() }}">
    @endif
@endsection

@section('content')
    @php
        $waUrl = $motorcycle->whatsappUrl($store['whatsapp_number']);
        $isSold = $motorcycle->status === 'sold';
        $taxActive = $motorcycle->isTaxActive();
    @endphp

    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        {{-- Breadcrumb --}}
        <nav aria-label="Breadcrumb" class="mb-5 flex flex-wrap items-center gap-2 text-xs font-medium text-muted">
            <a href="{{ route('home') }}" class="hover:text-ink">Beranda</a>
            <span aria-hidden="true">/</span>
            <a href="{{ route('catalog.index') }}" class="hover:text-ink">Katalog</a>
            <span aria-hidden="true">/</span>
            <span class="font-semibold text-ink">{{ $motorcycle->fullName() }} {{ $motorcycle->year }}</span>
        </nav>

        @if ($isSold)
            <div role="status" class="mb-6 rounded-lg border border-red-200 bg-red-50 px-5 py-4 text-red-950">
                <p class="text-base font-extrabold tracking-tight text-red-800">UNIT INI SUDAH TERJUAL</p>
                <p class="mt-1 text-sm text-red-900">
                    Motor {{ $motorcycle->fullName() }} ({{ $motorcycle->code }}) sudah laku terjual. Lihat rekomendasi unit lain yang masih tersedia di bawah halaman ini.
                </p>
            </div>
        @endif

        <div class="grid gap-8 lg:grid-cols-12">
            {{-- Left: Photo Gallery --}}
            <div class="lg:col-span-7">
                <div class="overflow-hidden rounded-xl border border-line bg-surface">
                    @if ($motorcycle->primaryPhotoUrl())
                        <img
                            id="detail-main-photo"
                            src="{{ $motorcycle->primaryPhotoUrl() }}"
                            alt="{{ $motorcycle->fullName() }} tahun {{ $motorcycle->year }} warna {{ $motorcycle->color }}"
                            width="960"
                            height="720"
                            fetchpriority="high"
                            decoding="async"
                            class="aspect-[4/3] w-full object-cover"
                        >
                    @else
                        <div class="flex aspect-[4/3] w-full flex-col items-center justify-center gap-2 text-muted">
                            <span class="text-sm font-medium">Foto unit belum tersedia</span>
                        </div>
                    @endif
                </div>

                @if ($motorcycle->photos->count() > 1)
                    <div class="mt-3 grid grid-cols-4 gap-2.5 sm:grid-cols-5">
                        @foreach ($motorcycle->photos as $index => $photo)
                            <button
                                type="button"
                                data-gallery-thumb="{{ $photo->url() }}"
                                aria-label="Tampilkan foto {{ $index + 1 }}"
                                aria-pressed="{{ $index === 0 ? 'true' : 'false' }}"
                                class="overflow-hidden rounded-md border {{ $index === 0 ? 'border-brand ring-2 ring-brand/20' : 'border-line' }} bg-surface"
                            >
                                <img
                                    src="{{ $photo->url() }}"
                                    alt="{{ $motorcycle->fullName() }} tampilan {{ $index + 1 }}"
                                    width="160"
                                    height="120"
                                    loading="lazy"
                                    class="aspect-[4/3] w-full object-cover"
                                >
                            </button>
                        @endforeach
                    </div>
                @endif

                {{-- Description & Condition Notes --}}
                @if ($motorcycle->description || $motorcycle->modification_notes || $motorcycle->engine_notes)
                    <section aria-labelledby="catatan-unit-heading" class="mt-6 rounded-xl border border-line bg-white p-5 sm:p-6">
                        <h2 id="catatan-unit-heading" class="text-base font-bold text-ink">Catatan Kondisi Unit</h2>
                        @if ($motorcycle->description)
                            <p class="mt-2.5 text-sm leading-relaxed text-ink">{{ $motorcycle->description }}</p>
                        @endif
                        @if ($motorcycle->modification_notes)
                            <div class="mt-4 rounded-md bg-surface px-4 py-3 text-sm">
                                <p class="font-semibold text-ink">Detail Modifikasi</p>
                                <p class="mt-0.5 text-muted">{{ $motorcycle->modification_notes }}</p>
                            </div>
                        @endif
                        @if ($motorcycle->engine_notes)
                            <div class="mt-3 rounded-md bg-surface px-4 py-3 text-sm">
                                <p class="font-semibold text-ink">Catatan Riwayat Mesin</p>
                                <p class="mt-0.5 text-muted">{{ $motorcycle->engine_notes }}</p>
                            </div>
                        @endif
                    </section>
                @endif
            </div>

            {{-- Right: Key Pricing, CTA & Mandatory Specifications (PRD 7.1.1) --}}
            <div class="lg:col-span-5">
                <div class="rounded-xl border border-line bg-white p-5 sm:p-6">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <x-status-badge :status="$motorcycle->status" />
                        <span class="text-xs font-semibold text-muted tabular-nums">Kode Unit: {{ $motorcycle->code }}</span>
                    </div>

                    <h1 class="mt-3 text-2xl font-extrabold tracking-tight text-ink sm:text-3xl">
                        {{ $motorcycle->fullName() }} {{ $motorcycle->year }}
                    </h1>

                    <div class="mt-4 flex flex-wrap items-baseline gap-2.5 border-y border-line py-4">
                        <p class="text-3xl font-extrabold tracking-tight text-ink tabular-nums">
                            {{ $motorcycle->formattedSellingPrice() }}
                        </p>
                        <span class="rounded bg-surface px-2.5 py-1 text-xs font-bold text-ink">
                            {{ $motorcycle->is_negotiable ? 'Bisa Nego' : 'Harga Pas' }}
                        </span>
                    </div>

                    @if (! $isSold)
                        <div class="mt-5 space-y-2.5">
                            <a
                                href="{{ $waUrl }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="btn-wa w-full text-base"
                            >
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M21 11.5a8.4 8.4 0 0 1-12.5 7.3L3 20l1.2-5.1A8.4 8.4 0 1 1 21 11.5Z" />
                                </svg>
                                Tanya via WhatsApp
                            </a>
                            <p class="text-center text-xs text-muted">
                                Pesan otomatis menyertakan nama motor dan kode unit {{ $motorcycle->code }}.
                            </p>
                        </div>
                    @endif

                    {{-- Complete specification list (PRD Section 7.1.1) --}}
                    <h2 class="mt-6 text-sm font-bold text-ink">Spesifikasi &amp; Kelengkapan</h2>
                    <dl class="mt-3 divide-y divide-line text-sm">
                        <div class="flex items-center justify-between gap-4 py-2.5">
                            <dt class="text-muted">Merek &amp; Model</dt>
                            <dd class="font-semibold text-ink text-right">{{ $motorcycle->fullName() }}</dd>
                        </div>
                        <div class="flex items-center justify-between gap-4 py-2.5">
                            <dt class="text-muted">Tahun</dt>
                            <dd class="font-semibold text-ink tabular-nums">{{ $motorcycle->year }}</dd>
                        </div>
                        <div class="flex items-center justify-between gap-4 py-2.5">
                            <dt class="text-muted">Jarak Tempuh (Odometer)</dt>
                            <dd class="font-semibold text-ink tabular-nums">{{ $motorcycle->formattedMileage() }}</dd>
                        </div>
                        <div class="flex items-center justify-between gap-4 py-2.5">
                            <dt class="text-muted">Warna / Mesin / Transmisi</dt>
                            <dd class="font-semibold text-ink text-right tabular-nums">
                                {{ $motorcycle->color }}, {{ $motorcycle->engine_cc }} cc, {{ $motorcycle->transmissionLabel() }}
                            </dd>
                        </div>
                        <div class="flex items-center justify-between gap-4 py-2.5">
                            <dt class="text-muted">Kondisi Setting</dt>
                            <dd class="font-semibold text-ink text-right">{{ $motorcycle->settingConditionLabel() }}</dd>
                        </div>
                        <div class="flex items-center justify-between gap-4 py-2.5">
                            <dt class="text-muted">Riwayat Bongkar Mesin</dt>
                            <dd class="font-semibold text-ink text-right">
                                {{ $motorcycle->engine_ever_opened ? 'Pernah turun mesin' : 'Belum pernah dibongkar' }}
                            </dd>
                        </div>
                        <div class="flex items-center justify-between gap-4 py-2.5">
                            <dt class="text-muted">Kelengkapan Surat</dt>
                            <dd class="flex flex-wrap justify-end gap-1.5">
                                <span class="rounded px-2 py-0.5 text-xs font-semibold {{ $motorcycle->has_bpkb ? 'bg-emerald-50 text-emerald-800' : 'bg-slate-100 text-slate-500' }}">
                                    BPKB {{ $motorcycle->has_bpkb ? 'Ada' : 'Tidak' }}
                                </span>
                                <span class="rounded px-2 py-0.5 text-xs font-semibold {{ $motorcycle->has_stnk ? 'bg-emerald-50 text-emerald-800' : 'bg-slate-100 text-slate-500' }}">
                                    STNK {{ $motorcycle->has_stnk ? 'Ada' : 'Tidak' }}
                                </span>
                                <span class="rounded px-2 py-0.5 text-xs font-semibold {{ $motorcycle->has_faktur ? 'bg-emerald-50 text-emerald-800' : 'bg-slate-100 text-slate-500' }}">
                                    Faktur {{ $motorcycle->has_faktur ? 'Ada' : 'Tidak' }}
                                </span>
                            </dd>
                        </div>
                        <div class="flex items-center justify-between gap-4 py-2.5">
                            <dt class="text-muted">Pajak</dt>
                            <dd class="text-right font-semibold {{ $taxActive === false ? 'text-brand' : 'text-ink' }}">
                                {{ $motorcycle->taxLabel() }}
                            </dd>
                        </div>
                        <div class="flex items-center justify-between gap-4 py-2.5">
                            <dt class="text-muted">Wilayah Plat Nomor</dt>
                            <dd class="font-semibold text-ink">
                                {{ $motorcycle->plate_region ? 'Plat '.$motorcycle->plate_region.' (nomor lengkap disembunyikan)' : 'Belum dicatat' }}
                            </dd>
                        </div>
                        <div class="flex items-center justify-between gap-4 py-2.5">
                            <dt class="text-muted">Garansi</dt>
                            <dd class="font-semibold text-ink text-right">{{ $motorcycle->warranty ?: 'Tidak ada' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        {{-- Related Available Units --}}
        @if ($relatedMotorcycles->isNotEmpty())
            <section aria-labelledby="unit-lain-heading" class="mt-14 border-t border-line pt-10">
                <div class="mb-6 flex items-end justify-between gap-4">
                    <h2 id="unit-lain-heading" class="text-xl font-extrabold tracking-tight text-ink">
                        {{ $isSold ? 'Rekomendasi Unit Lain yang Tersedia' : 'Unit Lain yang Mungkin Cocok' }}
                    </h2>
                    <a href="{{ route('catalog.index') }}" class="text-sm font-semibold text-brand hover:underline">
                        Lihat Semua
                    </a>
                </div>
                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($relatedMotorcycles as $related)
                        <x-motorcycle-card :motorcycle="$related" :whatsapp-number="$store['whatsapp_number']" />
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    {{-- Sticky Mobile WhatsApp CTA Bar (PRD 15.1 & 15.4) --}}
    @if (! $isSold)
        <div class="fixed inset-x-0 bottom-0 z-30 border-t border-line bg-white px-4 py-3 md:hidden">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-medium text-muted">Harga Jual</p>
                    <p class="text-base font-extrabold text-ink tabular-nums">{{ $motorcycle->formattedSellingPrice() }}</p>
                </div>
                <a
                    href="{{ $waUrl }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="btn-wa flex-1 text-sm"
                >
                    Tanya via WhatsApp
                </a>
            </div>
        </div>
    @endif
@endsection
