@extends('layouts.app')

@section('content')

<h1 class="mb-4 text-2xl font-bold">
    {{ isset($archive) ? 'Edit Arsip' : 'Tambah Arsip Skripsi' }}
</h1>

<form method="POST"
      action="{{ isset($archive) ? route('archives.update', $archive) : route('archives.store') }}"
      enctype="multipart/form-data"
      class="rounded bg-white p-4 shadow">

 
@csrf

@isset($archive)
    @method('PUT')
@endisset

@if(auth()->user()->isJurusan() || auth()->user()->isKetuaJurusan())
    <label class="mb-2 block font-semibold">Mahasiswa</label>
    <select name="student_id" class="mb-4 w-full rounded border p-2">
        <option value="">Gunakan akun saya</option>
        @foreach($students as $s)
            <option value="{{ $s->id }}"
                @selected(old('student_id', $archive->student_id ?? '') == $s->id)>
                {{ $s->name }} - {{ $s->identifier }}
            </option>
        @endforeach
    </select>
@else
    <label class="mb-2 block font-semibold">Mahasiswa</label>
    <input type="text"
           value="{{ auth()->user()->name }} - {{ auth()->user()->identifier }}"
           class="mb-4 w-full rounded border bg-slate-100 p-2"
           readonly>
@endif

<label class="mb-2 block font-semibold">Judul Skripsi</label>
<input name="title"
       value="{{ old('title', $archive->title ?? '') }}"
       class="mb-4 w-full rounded border p-2"
       required>

<div class="grid gap-4 md:grid-cols-2">
    <div>
        <label class="mb-2 block font-semibold">Tahun</label>
        <input name="year"
               value="{{ old('year', $archive->year ?? date('Y')) }}"
               class="mb-4 w-full rounded border p-2"
               required>
    </div>

    <div>
        <label class="mb-2 block font-semibold">Keyword</label>
        <input name="keywords"
               value="{{ old('keywords', $archive->keywords ?? '') }}"
               class="mb-4 w-full rounded border p-2">
    </div>
</div>

<label class="mb-2 block font-semibold">
    Dokumen Skripsi PDF {{ isset($archive) ? '(kosongkan jika tidak diganti)' : '' }}
</label>
<input type="file"
       name="file"
       accept="application/pdf"
       class="mb-4 w-full rounded border p-2"
       {{ isset($archive) ? '' : 'required' }}>

@if(auth()->user()->isJurusan() || auth()->user()->isKetuaJurusan())
    <label class="mb-4 flex items-center gap-2">
        <input type="checkbox"
               name="is_public"
               value="1"
               @checked(old('is_public', $archive->is_public ?? true))>

        Publik untuk pencarian referensi
    </label>
@else
    <div class="mb-4 rounded bg-yellow-50 p-3 text-sm text-yellow-800">
        Arsip yang diupload mahasiswa akan menunggu verifikasi jurusan sebelum dipublikasikan.
    </div>
@endif

<button class="rounded bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
    Simpan Arsip
</button>
 

</form>
@endsection
