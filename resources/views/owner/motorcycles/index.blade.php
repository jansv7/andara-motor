@extends('layouts.owner')

@section('title', 'Inventori Unit Motor')
@section('page_title', 'Inventori Unit Motor')

@section('header_actions')
    <a href="{{ route('owner.motorcycles.create') }}" class="btn-primary text-sm">
        Tambah Unit
    </a>
@endsection

@section('content')
    <section aria-label="Filter inventori unit" class="mb-6 rounded-lg border border-line bg-white p-4">
        <search>
            <form method="GET" action="{{ route('owner.motorcycles.index') }}" class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <label for="filter-q" class="block text-xs font-semibold text-muted">Cari Model / Kode</label>
                    <input
                        id="filter-q"
                        name="q"
                        type="search"
                        value="{{ $filters['q'] ?? '' }}"
                        placeholder="Vario, NMAX, MTR-0001"
                        class="mt-1 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-ink"
                    >
                </div>

                <div>
                    <label for="filter-brand" class="block text-xs font-semibold text-muted">Merek</label>
                    <select id="filter-brand" name="brand" class="mt-1 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-ink">
                        <option value="">Semua Merek</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" @selected(($filters['brand'] ?? '') == $brand->id)>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="filter-status" class="block text-xs font-semibold text-muted">Status Stok</label>
                    <select id="filter-status" name="status" class="mt-1 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-ink">
                        <option value="">Semua Status</option>
                        <option value="available" @selected(($filters['status'] ?? '') === 'available')>Tersedia</option>
                        <option value="booked" @selected(($filters['status'] ?? '') === 'booked')>Dipesan</option>
                        <option value="sold" @selected(($filters['status'] ?? '') === 'sold')>Terjual</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="btn-dark flex-1 text-sm">Terapkan</button>
                    @if (! empty($filters['q']) || ! empty($filters['brand']) || ! empty($filters['status']))
                        <a href="{{ route('owner.motorcycles.index') }}" class="btn-secondary text-sm">Reset</a>
                    @endif
                </div>
            </form>
        </search>
    </section>

    <section aria-labelledby="inventory-table-heading" class="rounded-lg border border-line bg-white">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-line px-5 py-4">
            <div>
                <h2 id="inventory-table-heading" class="text-base font-bold text-ink">Daftar Unit Motor</h2>
                <p class="text-xs text-muted">Status Terjual hanya dicatat lewat modul transaksi penjualan agar tidak ada transaksi terlewat.</p>
            </div>
            <span class="text-xs font-semibold text-muted tabular-nums">{{ $motorcycles->total() }} unit</span>
        </div>

        @if ($motorcycles->isEmpty())
            <div class="px-6 py-12 text-center">
                @if (! empty($filters['q']) || ! empty($filters['brand']) || ! empty($filters['status']))
                    <p class="text-base font-bold text-ink">Tidak ada unit yang cocok dengan filter</p>
                    <p class="mt-1 text-sm text-muted">Ubah kata kunci pencarian atau reset filter untuk melihat seluruh stok.</p>
                    <div class="mt-5">
                        <a href="{{ route('owner.motorcycles.index') }}" class="btn-secondary">Reset Filter</a>
                    </div>
                @else
                    <p class="text-base font-bold text-ink">Inventori masih kosong</p>
                    <p class="mt-1 text-sm text-muted">Mulai tambahkan unit motor beserta fotonya untuk ditampilkan di katalog publik.</p>
                    <div class="mt-5">
                        <a href="{{ route('owner.motorcycles.create') }}" class="btn-primary">Tambah Unit Pertama</a>
                    </div>
                @endif
            </div>
        @else
            <div tabindex="0" role="region" aria-labelledby="inventory-table-heading" class="table-wrapper">
                <table class="data-table data-table--stack text-left text-sm">
                    <thead>
                        <tr class="border-b border-line text-xs font-semibold text-muted">
                            <th scope="col" class="px-5 py-3">Unit</th>
                            <th scope="col" class="px-4 py-3">Spesifikasi</th>
                            <th scope="col" class="px-4 py-3">Harga Beli</th>
                            <th scope="col" class="px-4 py-3">Harga Jual</th>
                            <th scope="col" class="px-4 py-3">Status</th>
                            <th scope="col" class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line">
                        @foreach ($motorcycles as $motorcycle)
                            <tr class="hover:bg-surface/60">
                                <th scope="row" data-label="Unit" class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        @if ($motorcycle->primaryPhotoUrl())
                                            <img
                                                src="{{ $motorcycle->primaryPhotoUrl() }}"
                                                alt="{{ $motorcycle->fullName() }}"
                                                width="64"
                                                height="48"
                                                loading="lazy"
                                                class="h-12 w-16 shrink-0 rounded border border-line object-cover"
                                            >
                                        @else
                                            <div class="flex h-12 w-16 shrink-0 items-center justify-center rounded border border-line bg-surface text-xs text-muted">
                                                Foto
                                            </div>
                                        @endif
                                        <div class="text-left">
                                            <a href="{{ route('owner.motorcycles.show', $motorcycle) }}" class="font-bold text-ink hover:text-brand">
                                                {{ $motorcycle->fullName() }}
                                            </a>
                                            <p class="text-xs text-muted tabular-nums">
                                                {{ $motorcycle->code }}
                                                @if ($motorcycle->is_featured)
                                                    &middot; <span class="font-semibold text-brand">Unggulan</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </th>
                                <td data-label="Spesifikasi" class="px-4 py-3.5 text-muted tabular-nums">
                                    {{ $motorcycle->year }} &middot; {{ $motorcycle->engine_cc }} cc &middot; {{ $motorcycle->formattedMileage() }}
                                </td>
                                <td data-label="Harga Beli" class="px-4 py-3.5 text-muted tabular-nums">
                                    {{ $motorcycle->formattedPurchasePrice() }}
                                </td>
                                <td data-label="Harga Jual" class="px-4 py-3.5 font-bold text-ink tabular-nums">
                                    {{ $motorcycle->formattedSellingPrice() }}
                                </td>
                                <td data-label="Status" class="px-4 py-3.5">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <x-status-badge :status="$motorcycle->status" />
                                        @if ($motorcycle->status !== 'sold')
                                            @php
                                                $nextStatus = $motorcycle->status === 'available' ? 'booked' : 'available';
                                                $nextLabel = $nextStatus === 'booked' ? 'Tandai Dipesan' : 'Tandai Tersedia';
                                            @endphp
                                            <form method="POST" action="{{ route('owner.motorcycles.status', $motorcycle) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="{{ $nextStatus }}">
                                                <button type="submit" class="text-xs font-semibold text-muted underline hover:text-ink">
                                                    {{ $nextLabel }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                                <td data-label="Aksi" class="px-5 py-3.5 text-right">
                                    <div class="inline-flex items-center gap-1.5">
                                        <a href="{{ route('owner.motorcycles.show', $motorcycle) }}" class="rounded border border-line bg-white px-2.5 py-1.5 text-xs font-semibold text-ink hover:bg-surface">
                                            Detail
                                        </a>
                                        <a href="{{ route('owner.motorcycles.edit', $motorcycle) }}" class="rounded border border-line bg-white px-2.5 py-1.5 text-xs font-semibold text-ink hover:bg-surface">
                                            Edit
                                        </a>
                                        @if ($motorcycle->status !== 'sold')
                                            <form
                                                method="POST"
                                                action="{{ route('owner.motorcycles.destroy', $motorcycle) }}"
                                                data-confirm="Hapus unit {{ $motorcycle->fullName() }} ({{ $motorcycle->code }})?"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded border border-red-200 bg-red-50 px-2.5 py-1.5 text-xs font-semibold text-red-800 hover:bg-red-100">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($motorcycles->hasPages())
                <div class="border-t border-line px-5 py-4">
                    {{ $motorcycles->links() }}
                </div>
            @endif
        @endif
    </section>
@endsection
