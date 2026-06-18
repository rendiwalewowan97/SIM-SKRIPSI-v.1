@extends('layouts.app')
@section('content')
<h1 class="mb-4 text-2xl font-bold">{{ isset($title) ? 'Edit Pengajuan Judul' : 'Ajukan Judul Skripsi' }}</h1>
<form method="POST" action="{{ isset($title) ? route('titles.update',$title) : route('titles.store') }}" class="rounded bg-white p-4 shadow">
@csrf @isset($title) @method('PUT') @endisset
<label class="mb-2 block font-semibold">Judul</label>
<input name="title" value="{{ old('title',$title->title ?? '') }}" class="mb-4 w-full rounded border p-2" required>
<label class="mb-2 block font-semibold">Jumlah SKS yang Telah Lulus</label>
<input type="number" min="0" max="200" name="sks" value="{{ old('sks',$title->sks ?? '') }}" class="mb-4 w-full rounded border p-2" required>
<label class="mb-2 block font-semibold">Latar Belakang Singkat</label>
<textarea name="background" rows="7" class="mb-4 w-full rounded border p-2">{{ old('background',$title->background ?? '') }}</textarea>
<button class="rounded bg-indigo-600 px-4 py-2 text-white">Simpan</button>
<a href="{{ route('titles.index') }}" class="ml-2 text-slate-600">Kembali</a>
</form>
@endsection
