@extends('layouts.public')

@section('title', 'Katalog Motor Bekas | '.$store['store_name'])
@section('meta_description', 'Cari dan filter motor bekas tersedia di '.$store['store_name'].' berdasarkan merek, kategori, harga, dan tahun.')

@section('content')
    @php
        $hasActiveFilters = collect($filters)->except('sort')->filter(fn ($v) => $v !== null && $v !== '')->isNotEmpty();
    @endphp

    <section class="border-b border-line bg-surface">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-extrabold tracking-tight text-ink sm:text-3xl">
                Katalog Motor Bekas {{ $store['store_name'] }}
            </h1>
            <p class="mt-1.5 text-sm text-muted">
                Menampilkan unit berstatus Tersedia dan Dipesan secara real-time. Total <span class="font-bold text-ink tabular-nums">{{ $motorcycles->total() }} unit</span> ditemukan.
            </p>

            {{-- Filter & Search Form (query string preserved per US-01) --}}
            <search class="mt-6 block">
                <form method="GET" action="{{ route('catalog.index') }}" class="rounded-lg border border-line bg-white p-4">
                    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-6">
                        <div class="lg:col-span-2">
                            <label for="q" class="block text-xs font-semibold text-muted">Kata Kunci</label>
                            <input
                                id="q"
                                name="q"
                                type="search"
                                value="{{ $filters['q'] ?? '' }}"
                                placeholder="Merek, model, atau warna"
                                class="mt-1 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-ink"
                            >
                        </div>

                        <div>
                            <label for="brand" class="block text-xs font-semibold text-muted">Merek</label>
                            <select id="brand" name="brand" class="mt-1 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-ink">
                                <option value="">Semua Merek</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->slug }}" @selected(($filters['brand'] ?? '') === $brand->slug)>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="category" class="block text-xs font-semibold text-muted">Kategori</label>
                            <select id="category" name="category" class="mt-1 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-ink">
                                <option value="">Semua Kategori</option>
                                @foreach (['matic' => 'Matic', 'bebek' => 'Bebek', 'sport' => 'Sport', 'trail' => 'Trail', 'lainnya' => 'Lainnya'] as $val => $label)
                                    <option value="{{ $val }}" @selected(($filters['category'] ?? '') === $val)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="transmission" class="block text-xs font-semibold text-muted">Transmisi</label>
                            <select id="transmission" name="transmission" class="mt-1 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-ink">
                                <option value="">Semua Transmisi</option>
                                @foreach (['matic' => 'Matic', 'manual' => 'Manual', 'kopling' => 'Kopling'] as $val => $label)
                                    <option value="{{ $val }}" @selected(($filters['transmission'] ?? '') === $val)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="sort" class="block text-xs font-semibold text-muted">Urutkan</label>
                            <select id="sort" name="sort" class="mt-1 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-ink">
                                <option value="newest" @selected(($filters['sort'] ?? 'newest') === 'newest')>Terbaru</option>
                                <option value="price_asc" @selected(($filters['sort'] ?? '') === 'price_asc')>Harga Termurah</option>
                                <option value="price_desc" @selected(($filters['sort'] ?? '') === 'price_desc')>Harga Termahal</option>
                                <option value="year_desc" @selected(($filters['sort'] ?? '') === 'year_desc')>Tahun Terbaru</option>
                                <option value="mileage_asc" @selected(($filters['sort'] ?? '') === 'mileage_asc')>Kilometer Terendah</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-3 grid gap-3 border-t border-line pt-3 sm:grid-cols-2 lg:grid-cols-6">
                        <div>
                            <label for="min_price" class="block text-xs font-semibold text-muted">Harga Min (Rp)</label>
                            <input
                                id="min_price"
                                name="min_price"
                                type="number"
                                inputmode="numeric"
                                min="0"
                                step="500000"
                                value="{{ $filters['min_price'] ?? '' }}"
                                placeholder="10000000"
                                class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-ink tabular-nums"
                            >
                        </div>

                        <div>
                            <label for="max_price" class="block text-xs font-semibold text-muted">Harga Maks (Rp)</label>
                            <input
                                id="max_price"
                                name="max_price"
                                type="number"
                                inputmode="numeric"
                                min="0"
                                step="500000"
                                value="{{ $filters['max_price'] ?? '' }}"
                                placeholder="30000000"
                                class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-ink tabular-nums"
                            >
                        </div>

                        <div>
                            <label for="min_year" class="block text-xs font-semibold text-muted">Tahun Min</label>
                            <input
                                id="min_year"
                                name="min_year"
                                type="number"
                                inputmode="numeric"
                                min="1990"
                                max="{{ date('Y') }}"
                                value="{{ $filters['min_year'] ?? '' }}"
                                placeholder="2018"
                                class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-ink tabular-nums"
                            >
                        </div>

                        <div>
                            <label for="max_year" class="block text-xs font-semibold text-muted">Tahun Maks</label>
                            <input
                                id="max_year"
                                name="max_year"
                                type="number"
                                inputmode="numeric"
                                min="1990"
                                max="{{ date('Y') }}"
                                value="{{ $filters['max_year'] ?? '' }}"
                                placeholder="{{ date('Y') }}"
                                class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-ink tabular-nums"
                            >
                        </div>

                        <div class="flex items-end gap-2 sm:col-span-2">
                            <button type="submit" class="btn-primary flex-1 text-sm">Terapkan Filter</button>
                            @if ($hasActiveFilters || ! empty($filters['sort']))
                                <a href="{{ route('catalog.index') }}" class="btn-secondary text-sm">Reset Filter</a>
                            @endif
                        </div>
                    </div>
                </form>
            </search>
        </div>
    </section>

    <section aria-label="Daftar Unit Katalog" class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        @if ($motorcycles->isEmpty())
            <div class="rounded-xl border border-line bg-surface px-6 py-16 text-center">
                <p class="text-lg font-bold text-ink">Unit tidak ditemukan</p>
                <p class="mt-1.5 text-sm text-muted">
                    Tidak ada motor yang sesuai dengan kriteria pencarian Anda saat ini. Coba longgarkan rentang harga atau reset filter.
                </p>
                <div class="mt-6">
                    <a href="{{ route('catalog.index') }}" class="btn-primary">Reset Semua Filter</a>
                </div>
            </div>
        @else
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($motorcycles as $motorcycle)
                    <x-motorcycle-card :motorcycle="$motorcycle" :whatsapp-number="$store['whatsapp_number']" />
                @endforeach
            </div>

            @if ($motorcycles->hasPages())
                <div class="mt-10">
                    {{ $motorcycles->links() }}
                </div>
            @endif
        @endif
    </section>
@endsection
