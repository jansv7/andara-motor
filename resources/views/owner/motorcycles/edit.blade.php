@extends('layouts.owner')

@section('title', 'Edit Unit '.$motorcycle->code)
@section('page_title', 'Edit Unit: '.$motorcycle->fullName().' ('.$motorcycle->code.')')

@section('content')
    <form
        method="POST"
        action="{{ route('owner.motorcycles.update', $motorcycle) }}"
        enctype="multipart/form-data"
        data-prevent-double-submit
    >
        @csrf
        @method('PUT')

        @include('owner.motorcycles._form', ['motorcycle' => $motorcycle])

        <div class="mt-6 flex flex-wrap items-center gap-3">
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
            <a href="{{ route('owner.motorcycles.show', $motorcycle) }}" class="btn-secondary">Lihat Detail</a>
            <a href="{{ route('owner.motorcycles.index') }}" class="btn-secondary">Kembali ke Daftar</a>
        </div>
    </form>
@endsection
