@extends('layouts.owner')

@section('title', 'Master Merek Motor')
@section('page_title', 'Master Merek Motor')

@section('header_actions')
    <a href="{{ route('owner.brands.create') }}" class="btn-primary text-sm">
        Tambah Merek
    </a>
@endsection

@section('content')
    <section aria-labelledby="brands-heading" class="rounded-lg border border-line bg-white">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-line px-5 py-4">
            <div>
                <h2 id="brands-heading" class="text-base font-bold text-ink">Daftar Merek Terdaftar</h2>
                <p class="text-xs text-muted">Merek yang masih memiliki unit motor tidak dapat dihapus.</p>
            </div>
            <span class="text-xs font-semibold text-muted tabular-nums">{{ $brands->total() }} merek</span>
        </div>

        @if ($brands->isEmpty())
            <div class="px-6 py-12 text-center">
                <p class="text-base font-bold text-ink">Belum ada merek terdaftar</p>
                <p class="mt-1 text-sm text-muted">Tambahkan merek motor terlebih dahulu sebelum menginput unit baru.</p>
                <div class="mt-5">
                    <a href="{{ route('owner.brands.create') }}" class="btn-primary">
                        Tambah Merek Pertama
                    </a>
                </div>
            </div>
        @else
            <div tabindex="0" role="region" aria-labelledby="brands-heading" class="table-wrapper">
                <table class="data-table data-table--stack text-left text-sm">
                    <thead>
                        <tr class="border-b border-line text-xs font-semibold text-muted">
                            <th scope="col" class="px-5 py-3">Nama Merek</th>
                            <th scope="col" class="px-4 py-3">Slug URL</th>
                            <th scope="col" class="px-4 py-3">Jumlah Unit</th>
                            <th scope="col" class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line">
                        @foreach ($brands as $brand)
                            <tr class="hover:bg-surface/60">
                                <th scope="row" data-label="Nama Merek" class="px-5 py-3.5 font-bold text-ink">
                                    {{ $brand->name }}
                                </th>
                                <td data-label="Slug URL" class="px-4 py-3.5 text-muted">
                                    {{ $brand->slug }}
                                </td>
                                <td data-label="Jumlah Unit" class="px-4 py-3.5 font-semibold text-ink tabular-nums">
                                    {{ $brand->motorcycles_count }} unit
                                </td>
                                <td data-label="Aksi" class="px-5 py-3.5 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('owner.brands.edit', $brand) }}" class="rounded border border-line bg-white px-3 py-1.5 text-xs font-semibold text-ink hover:bg-surface">
                                            Edit
                                        </a>
                                        <form
                                            method="POST"
                                            action="{{ route('owner.brands.destroy', $brand) }}"
                                            data-confirm="Hapus merek {{ $brand->name }}?"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="rounded border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-800 hover:bg-red-100"
                                            >
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($brands->hasPages())
                <div class="border-t border-line px-5 py-4">
                    {{ $brands->links() }}
                </div>
            @endif
        @endif
    </section>
@endsection
