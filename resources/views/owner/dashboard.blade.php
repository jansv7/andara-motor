@extends('layouts.owner')

@section('title', 'Dashboard Owner')
@section('page_title', 'Dashboard Showroom')

@section('header_actions')
    <a href="{{ route('owner.motorcycles.create') }}" class="btn-primary text-sm">
        Tambah Unit
    </a>
@endsection

@section('content')
    <section aria-labelledby="ringkasan-stok-heading">
        <div class="mb-4 flex flex-wrap items-end justify-between gap-3">
            <div>
                <h2 id="ringkasan-stok-heading" class="text-lg font-bold text-ink">Ringkasan Stok Saat Ini</h2>
                <p class="text-sm text-muted">Data langsung dari inventori aktif Andara Motor.</p>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-lg border border-line bg-white p-5">
                <p class="text-xs font-semibold text-muted">Unit Tersedia</p>
                <p class="mt-2 text-3xl font-extrabold text-ink tabular-nums">{{ $availableCount }}</p>
                <p class="mt-1 text-xs text-emerald-700">Tampil aktif di katalog publik</p>
            </div>

            <div class="rounded-lg border border-line bg-white p-5">
                <p class="text-xs font-semibold text-muted">Unit Dipesan (DP)</p>
                <p class="mt-2 text-3xl font-extrabold text-ink tabular-nums">{{ $bookedCount }}</p>
                <p class="mt-1 text-xs text-amber-800">Menunggu pelunasan pembeli</p>
            </div>

            <div class="rounded-lg border border-line bg-white p-5">
                <p class="text-xs font-semibold text-muted">Unit Terjual</p>
                <p class="mt-2 text-3xl font-extrabold text-ink tabular-nums">{{ $soldCount }}</p>
                <p class="mt-1 text-xs text-muted">Otomatis disembunyikan dari katalog</p>
            </div>

            <div class="rounded-lg border border-line bg-white p-5">
                <p class="text-xs font-semibold text-muted">Merek Terdaftar</p>
                <p class="mt-2 text-3xl font-extrabold text-ink tabular-nums">{{ $brandCount }}</p>
                <a href="{{ route('owner.brands.index') }}" class="mt-1 inline-block text-xs font-semibold text-brand hover:underline">
                    Kelola master merek
                </a>
            </div>
        </div>
    </section>

    <section aria-labelledby="unit-terbaru-heading" class="mt-8 rounded-lg border border-line bg-white">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-line px-5 py-4">
            <div>
                <h2 id="unit-terbaru-heading" class="text-base font-bold text-ink">Unit Motor Terbaru</h2>
                <p class="text-xs text-muted">Harga beli hanya terlihat di panel ini dan tidak pernah dikirim ke katalog publik.</p>
            </div>
            <a href="{{ route('owner.motorcycles.index') }}" class="text-sm font-semibold text-brand hover:underline">
                Lihat semua unit
            </a>
        </div>

        @if ($recentMotorcycles->isEmpty())
            <div class="px-6 py-12 text-center">
                <p class="text-base font-bold text-ink">Belum ada unit motor di inventori</p>
                <p class="mt-1 text-sm text-muted">Tambahkan unit pertama Anda agar langsung muncul di katalog publik Andara Motor.</p>
                <div class="mt-5">
                    <a href="{{ route('owner.motorcycles.create') }}" class="btn-primary">
                        Tambah Unit Motor
                    </a>
                </div>
            </div>
        @else
            <div tabindex="0" role="region" aria-labelledby="unit-terbaru-heading" class="table-wrapper">
                <table class="data-table data-table--stack text-left text-sm">
                    <thead>
                        <tr class="border-b border-line text-xs font-semibold text-muted">
                            <th scope="col" class="px-5 py-3">Unit</th>
                            <th scope="col" class="px-4 py-3">Tahun / KM</th>
                            <th scope="col" class="px-4 py-3">Harga Beli</th>
                            <th scope="col" class="px-4 py-3">Harga Jual</th>
                            <th scope="col" class="px-4 py-3">Status</th>
                            <th scope="col" class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line">
                        @foreach ($recentMotorcycles as $motorcycle)
                            <tr class="hover:bg-surface/60">
                                <th scope="row" data-label="Unit" class="px-5 py-3.5 font-semibold text-ink">
                                    <div class="flex items-center gap-3">
                                        @if ($motorcycle->primaryPhotoUrl())
                                            <img
                                                src="{{ $motorcycle->primaryPhotoUrl() }}"
                                                alt="{{ $motorcycle->fullName() }}"
                                                width="56"
                                                height="42"
                                                loading="lazy"
                                                class="h-11 w-14 shrink-0 rounded border border-line object-cover"
                                            >
                                        @endif
                                        <div class="text-left">
                                            <p class="font-bold text-ink">{{ $motorcycle->fullName() }}</p>
                                            <p class="text-xs font-medium text-muted tabular-nums">{{ $motorcycle->code }}</p>
                                        </div>
                                    </div>
                                </th>
                                <td data-label="Tahun / KM" class="px-4 py-3.5 text-muted tabular-nums">
                                    {{ $motorcycle->year }} &middot; {{ $motorcycle->formattedMileage() }}
                                </td>
                                <td data-label="Harga Beli" class="px-4 py-3.5 font-medium text-muted tabular-nums">
                                    {{ $motorcycle->formattedPurchasePrice() }}
                                </td>
                                <td data-label="Harga Jual" class="px-4 py-3.5 font-bold text-ink tabular-nums">
                                    {{ $motorcycle->formattedSellingPrice() }}
                                </td>
                                <td data-label="Status" class="px-4 py-3.5">
                                    <x-status-badge :status="$motorcycle->status" />
                                </td>
                                <td data-label="Aksi" class="px-5 py-3.5 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('owner.motorcycles.show', $motorcycle) }}" class="rounded border border-line bg-white px-2.5 py-1.5 text-xs font-semibold text-ink hover:bg-surface">
                                            Detail
                                        </a>
                                        <a href="{{ route('owner.motorcycles.edit', $motorcycle) }}" class="rounded border border-line bg-white px-2.5 py-1.5 text-xs font-semibold text-ink hover:bg-surface">
                                            Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endsection
