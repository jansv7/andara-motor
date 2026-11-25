@extends('layouts.owner')

@section('title', 'Tambah Merek Motor')
@section('page_title', 'Tambah Merek Motor')

@section('content')
    <div class="max-w-xl rounded-lg border border-line bg-white p-6">
        <h2 class="text-base font-bold text-ink">Informasi Merek Baru</h2>
        <p class="mt-1 text-sm text-muted">Slug URL akan dibuat otomatis dari nama merek.</p>

        <form method="POST" action="{{ route('owner.brands.store') }}" class="mt-6 space-y-5" data-prevent-double-submit>
            @csrf

            <div>
                <label for="name" class="block text-sm font-semibold text-ink">
                    Nama Merek <span class="text-brand" aria-hidden="true">*</span>
                </label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    required
                    maxlength="50"
                    placeholder="Contoh: Vespa"
                    @error('name') aria-invalid="true" aria-describedby="name-error" @enderror
                    class="mt-1.5 block w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-ink placeholder:text-slate-400 focus:border-brand"
                >
                @error('name')
                    <p id="name-error" role="alert" class="mt-1.5 text-sm font-medium text-brand">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-wrap items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">Simpan Merek</button>
                <a href="{{ route('owner.brands.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
