@extends('layouts.app')
@section('content')
<h1 class="mb-4 text-2xl font-bold">{{ isset($archive) ? 'Edit Arsip' : 'Tambah Arsip Skripsi' }}</h1>
<form method="POST" action="{{ isset($archive) ? route('archives.update',$archive) : route('archives.store') }}" enctype="multipart/form-data" class="rounded bg-white p-4 shadow">@csrf @isset($archive) @method('PUT') @endisset
@if(auth()->user()->isJurusan())<label class="mb-2 block font-semibold">Mahasiswa</label><select name="student_id" class="mb-4 w-full rounded border p-2"><option value="">Gunakan akun saya</option>@foreach($students as $s)<option value="{{ $s->id }}" @selected(old('student_id',$archive->student_id ?? '')==$s->id)>{{ $s->name }} - {{ $s->identifier }}</option>@endforeach</select>@endif
<label class="mb-2 block font-semibold">Judul Skripsi</label><input name="title" value="{{ old('title',$archive->title ?? '') }}" class="mb-4 w-full rounded border p-2" required>
<div class="grid gap-4 md:grid-cols-2"><div><label class="mb-2 block font-semibold">Tahun</label><input name="year" value="{{ old('year',$archive->year ?? date('Y')) }}" class="mb-4 w-full rounded border p-2" required></div><div><label class="mb-2 block font-semibold">Keyword</label><input name="keywords" value="{{ old('keywords',$archive->keywords ?? '') }}" class="mb-4 w-full rounded border p-2"></div></div>
<label class="mb-2 block font-semibold">File Skripsi PDF {{ isset($archive) ? '(kosongkan jika tidak diganti)' : '' }}</label><input type="file" name="file" class="mb-4 w-full rounded border p-2" {{ isset($archive) ? '' : 'required' }}>
<label class="mb-2 block font-semibold">File Abstrak PDF</label><input type="file" name="abstract" class="mb-4 w-full rounded border p-2">
<label class="mb-4 flex items-center gap-2"><input type="checkbox" name="is_public" value="1" @checked(old('is_public',$archive->is_public ?? true))> Publik untuk pencarian referensi</label>
<button class="rounded bg-indigo-600 px-4 py-2 text-white">Simpan Arsip</button>
</form>
@endsection
