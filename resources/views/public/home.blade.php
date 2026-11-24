@extends('layouts.public')

@section('title', $store['store_name'].' | Katalog Motor Bekas Siap Pakai')
@section('meta_description', $store['store_tagline'].'. Cek stok tersedia, detail surat, pajak, dan kilometer secara transparan.')

@section('content')
    @php
        $waPhone = preg_replace('/\D+/', '', $store['whatsapp_number'] ?? '6281234567890');
        $waHeroUrl = 'https://wa.me/'.$waPhone.'?text='.rawurlencode('Halo '.$store['store_name'].', saya ingin tanya stok motor bekas yang tersedia hari ini.');

        $categories = [
            ['key' => 'matic', 'name' => 'Motor Matic', 'desc' => 'Nyaman untuk harian & dalam kota'],
            ['key' => 'sport', 'name' => 'Motor Sport', 'desc' => 'Performa mantap & kopling responsif'],
            ['key' => 'bebek', 'name' => 'Motor Bebek', 'desc' => 'Irit bahan bakar & tangguh'],
            ['key' => 'trail', 'name' => 'Motor Trail', 'desc' => 'Siap jalur beragam medan'],
        ];
    @endphp

    {{-- 1. Hero Banner (inspired by dark showroom showcase in visual reference) --}}
    <section class="relative overflow-hidden bg-ink text-white">
        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8 lg:py-16">
            <div class="grid items-center gap-8 lg:grid-cols-12 lg:gap-10">
                <div class="hero-enter space-y-5 lg:col-span-6">
                    <p class="text-sm font-semibold text-slate-300 tabular-nums">
                        {{ $totalReady }} unit siap cek langsung di {{ $store['store_address'] }}
                    </p>

                    <h1 class="text-4xl font-extrabold leading-[1.08] tracking-tight text-white sm:text-5xl">
                        Motor Bekas Pilihan.
                        <span class="block text-red-500">Surat Lengkap &amp; Jelas.</span>
                    </h1>

                    <p class="max-w-lg text-base leading-relaxed text-slate-300">
                        Semua unit di {{ $store['store_name'] }} dilengkapi informasi tahun, jarak tempuh, status pajak, kelengkapan surat, serta riwayat mesin sebelum Anda datang ke showroom.
                    </p>

                    <div class="flex flex-wrap items-center gap-3 pt-1">
                        <a href="{{ route('catalog.index') }}" class="btn-primary">
                            Lihat Katalog Motor
                        </a>
                        <a
                            href="{{ $waHeroUrl }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex min-h-11 items-center justify-center rounded-md border border-white/30 bg-transparent px-5 py-2.5 text-sm font-semibold text-white hover:bg-white/10"
                        >
                            Tanya via WhatsApp
                        </a>
                    </div>
                </div>

                <div class="hero-enter-delay lg:col-span-6">
                    <div class="overflow-hidden rounded-xl border border-white/15 bg-ink-soft">
                        <img
                            src="{{ asset('images/motorcycles/photo-f13967336-960.jpg') }}"
                            alt="Unit motor matic merah siap cek di showroom Andara Motor"
                            width="960"
                            height="722"
                            fetchpriority="high"
                            decoding="async"
                            class="aspect-[4/3] w-full object-cover"
                        >
                    </div>
                </div>
            </div>

            {{-- Docked showroom standards strip (real operational facts, no fake numbers) --}}
            <div class="mt-10 grid gap-4 border-t border-white/10 pt-6 sm:grid-cols-2 lg:grid-cols-4">
                <div class="flex items-start gap-3">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-red-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M9 12.75 11.25 15 15 9.75" />
                        <path d="M12 3 4 7v6c0 5 3.5 7.5 8 9 4.5-1.5 8-4 8-9V7l-8-4Z" />
                    </svg>
                    <div>
                        <p class="text-sm font-bold text-white">Surat Terverifikasi</p>
                        <p class="text-xs text-slate-300">Status BPKB, STNK &amp; faktur tercatat per unit.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-red-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <circle cx="12" cy="12" r="9" />
                        <path d="M12 7v5l3 2" />
                    </svg>
                    <div>
                        <p class="text-sm font-bold text-white">Stok Real-Time</p>
                        <p class="text-xs text-slate-300">Unit terjual langsung hilang dari katalog aktif.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-red-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M14.7 6.3a4 4 0 0 0-5.4 5.4l-5.3 5.3a1.5 1.5 0 0 0 2.1 2.1l5.3-5.3a4 4 0 0 0 5.4-5.4l-2.3 2.3-2.1-2.1 2.3-2.3Z" />
                    </svg>
                    <div>
                        <p class="text-sm font-bold text-white">Info Mesin Terbuka</p>
                        <p class="text-xs text-slate-300">Kondisi setting &amp; riwayat mesin dicantumkan jelas.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-red-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M21 11.5a8.4 8.4 0 0 1-12.5 7.3L3 20l1.2-5.1A8.4 8.4 0 1 1 21 11.5Z" />
                    </svg>
                    <div>
                        <p class="text-sm font-bold text-white">Chat Langsung Owner</p>
                        <p class="text-xs text-slate-300">Tanya unit &amp; jadwal cek langsung lewat WhatsApp.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. Quick Category Strip --}}
    <section aria-labelledby="kategori-heading" class="border-b border-line bg-surface">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <h2 id="kategori-heading" class="sr-only">Pilih Kategori Motor</h2>
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5">
                @foreach ($categories as $cat)
                    @php
                        $count = (int) ($categoryCounts[$cat['key']] ?? 0);
                    @endphp
                    <a
                        href="{{ route('catalog.index', ['category' => $cat['key']]) }}"
                        class="group flex flex-col justify-between rounded-lg border border-line bg-white p-4 transition hover:border-ink"
                    >
                        <div>
                            <p class="text-sm font-bold text-ink group-hover:text-brand">{{ $cat['name'] }}</p>
                            <p class="mt-1 text-xs text-muted">{{ $cat['desc'] }}</p>
                        </div>
                        <p class="mt-3 text-xs font-semibold text-ink tabular-nums">{{ $count }} unit siap</p>
                    </a>
                @endforeach

                <a
                    href="{{ route('catalog.index') }}"
                    class="group flex flex-col justify-between rounded-lg border border-ink bg-ink p-4 text-white transition hover:bg-ink-soft"
                >
                    <div>
                        <p class="text-sm font-bold text-white">Lihat Semua Unit</p>
                        <p class="mt-1 text-xs text-slate-300">Filter merek, harga, dan tahun</p>
                    </div>
                    <p class="mt-3 text-xs font-semibold text-red-400 tabular-nums">{{ $totalReady }} total stok</p>
                </a>
            </div>
        </div>
    </section>

    {{-- 3. Featured & Latest Motorcycles Grid --}}
    <section aria-labelledby="unit-pilihan-heading" class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="mb-7 flex flex-wrap items-end justify-between gap-4">
            <div>
                <h2 id="unit-pilihan-heading" class="text-2xl font-extrabold tracking-tight text-ink sm:text-3xl">
                    Unit Pilihan <span class="text-brand">{{ $store['store_name'] }}</span>
                </h2>
                <p class="mt-1 text-sm text-muted">
                    Stok tersedia dan dipesan terbaru. Klik unit untuk melihat kelengkapan surat, pajak, dan garansi.
                </p>
            </div>
            <a href="{{ route('catalog.index') }}" class="text-sm font-bold text-brand hover:underline">
                Lihat Semua Motor
            </a>
        </div>

        @if ($featuredMotorcycles->isEmpty())
            <div class="rounded-xl border border-line bg-surface px-6 py-14 text-center">
                <p class="text-lg font-bold text-ink">Stok katalog sedang diperbarui</p>
                <p class="mt-1 text-sm text-muted">Hubungi WhatsApp showroom kami untuk menanyakan unit yang baru masuk hari ini.</p>
                <div class="mt-5">
                    <a href="{{ $waHeroUrl }}" target="_blank" rel="noopener noreferrer" class="btn-wa">
                        Tanya Stok via WhatsApp
                    </a>
                </div>
            </div>
        @else
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($featuredMotorcycles as $motorcycle)
                    <x-motorcycle-card :motorcycle="$motorcycle" :whatsapp-number="$store['whatsapp_number']" />
                @endforeach
            </div>
        @endif
    </section>

    {{-- 4. Dark Contrast Showroom Inspection Banner (echoes mid-page dark bar in reference) --}}
    <section aria-labelledby="standar-unit-heading" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-xl bg-ink px-6 py-8 text-white sm:px-10 sm:py-10">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="max-w-xl">
                    <h2 id="standar-unit-heading" class="text-2xl font-extrabold tracking-tight text-white">
                        Apa yang Kami Periksa Sebelum Unit Masuk Katalog
                    </h2>
                    <p class="mt-2 text-sm leading-relaxed text-slate-300">
                        Setiap motor yang dipajang di website ini melewati pengecekan kelengkapan dokumen dan kondisi fisik sehingga Anda tidak perlu menanyakan detail dasar berulang kali lewat chat.
                    </p>
                </div>
                <div class="shrink-0">
                    <a href="{{ route('catalog.index') }}" class="btn-primary">
                        Jelajahi Katalog Lengkap
                    </a>
                </div>
            </div>

            <div class="mt-8 grid gap-4 border-t border-white/10 pt-7 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <p class="text-sm font-bold text-white">Dokumen Lengkap</p>
                    <p class="mt-1 text-xs leading-relaxed text-slate-300">Status BPKB, STNK, faktur, dan kode wilayah plat tercantum jelas di halaman unit.</p>
                </div>
                <div>
                    <p class="text-sm font-bold text-white">Masa Pajak Transparan</p>
                    <p class="mt-1 text-xs leading-relaxed text-slate-300">Sistem otomatis menandai pajak hidup maupun pajak mati sesuai tanggal jatuh tempo.</p>
                </div>
                <div>
                    <p class="text-sm font-bold text-white">Riwayat Setting &amp; Mesin</p>
                    <p class="mt-1 text-xs leading-relaxed text-slate-300">Keterangan standar pabrik atau modifikasi serta riwayat bongkar mesin dicatat terbuka.</p>
                </div>
                <div>
                    <p class="text-sm font-bold text-white">Cek Fisik di Lokasi</p>
                    <p class="mt-1 text-xs leading-relaxed text-slate-300">Kunjungi showroom di {{ $store['store_address'] }} pada jam buka untuk cek langsung.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- 5. Registered Brands Strip (#merek) --}}
    <section id="merek" aria-labelledby="merek-heading" class="mx-auto max-w-7xl px-4 pt-14 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-end justify-between gap-4">
            <div>
                <h2 id="merek-heading" class="text-xl font-extrabold tracking-tight text-ink sm:text-2xl">
                    Cari Berdasarkan Merek
                </h2>
                <p class="mt-1 text-sm text-muted">Pilih merek motor untuk langsung menyaring katalog tersedia.</p>
            </div>
            <a href="{{ route('catalog.index') }}" class="text-sm font-semibold text-brand hover:underline">
                Semua Merek
            </a>
        </div>

        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5">
            @foreach ($brands as $brand)
                <a
                    href="{{ route('catalog.index', ['brand' => $brand->slug]) }}"
                    class="flex flex-col items-center justify-center rounded-lg border border-line bg-white px-4 py-5 text-center transition hover:border-brand"
                >
                    <span class="text-base font-extrabold tracking-tight text-ink">{{ strtoupper($brand->name) }}</span>
                    <span class="mt-1 text-xs font-medium text-muted tabular-nums">
                        {{ $brand->available_count }} unit aktif
                    </span>
                </a>
            @endforeach
        </div>
    </section>
@endsection