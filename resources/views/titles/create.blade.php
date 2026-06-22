@extends('layouts.app')

@section('content')

<h1 class="mb-6 text-2xl font-bold">
    {{ isset($title) ? 'Edit Pengajuan Judul' : 'Ajukan Judul Skripsi' }}
</h1>

<form method="POST"
      action="{{ isset($title) ? route('titles.update', $title) : route('titles.store') }}"
      class="rounded-lg bg-white p-6 shadow">


@csrf
@isset($title)
    @method('PUT')
@endisset

{{-- Judul --}}
<div class="mb-5">
    <label class="mb-2 block font-semibold text-slate-700">
        Judul Skripsi
    </label>

    <input type="text"
           name="title"
           value="{{ old('title', $title->title ?? '') }}"
           class="w-full rounded border border-slate-300 p-2 focus:border-indigo-500 focus:outline-none"
           placeholder="Masukkan judul skripsi"
           required>

    @error('title')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- SKS --}}
<div class="mb-5">
    <label class="mb-2 block font-semibold text-slate-700">
        Jumlah SKS yang Telah Lulus
    </label>

    <input type="number"
           name="sks"
           min="112"
           max="200"
           value="{{ old('sks', $title->sks ?? '') }}"
           class="w-full rounded border border-slate-300 p-2 focus:border-indigo-500 focus:outline-none"
           required>

    <p class="mt-1 text-sm text-slate-500">
        Minimal telah lulus <strong>112 SKS</strong> untuk mengajukan judul skripsi.
    </p>

    @error('sks')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Latar Belakang --}}
<div class="mb-6">
    <label class="mb-2 block font-semibold text-slate-700">
        Latar Belakang Singkat
    </label>

    <textarea name="background"
              rows="7"
              class="w-full rounded border border-slate-300 p-2 focus:border-indigo-500 focus:outline-none"
              placeholder="Jelaskan latar belakang penelitian secara singkat">{{ old('background', $title->background ?? '') }}</textarea>

    @error('background')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Tombol --}}
<div class="flex items-center gap-2">
    <button type="submit"
            class="rounded bg-indigo-600 px-4 py-2 text-white transition hover:bg-indigo-700">
        Simpan
    </button>

    <a href="{{ route('titles.index') }}"
       class="rounded border border-slate-300 px-4 py-2 text-slate-700 transition hover:bg-slate-100">
        Kembali
    </a>
</div>


</form>

@endsection
