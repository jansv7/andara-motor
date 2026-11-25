@extends('layouts.owner')

@section('title', 'Tambah Unit Motor')
@section('page_title', 'Tambah Unit Motor Baru')

@section('content')
    <form
        method="POST"
        action="{{ route('owner.motorcycles.store') }}"
        enctype="multipart/form-data"
        data-prevent-double-submit
    >
        @csrf

        @include('owner.motorcycles._form')

        <div class="mt-6 flex flex-wrap items-center gap-3">
            <button type="submit" class="btn-primary">Simpan Unit ke Katalog</button>
            <a href="{{ route('owner.motorcycles.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
@endsection
