@extends('layouts.app')
@section('content')
<h1 class="mb-4 text-2xl font-bold">Review Bimbingan</h1>
<div class="mb-4 rounded bg-white p-4 shadow"><p><b>Mahasiswa:</b> {{ $guidance->student->name }}</p><p><b>Jenis:</b> {{ ucfirst($guidance->type) }} · {{ $guidance->chapter }}</p><p class="mt-3 whitespace-pre-line">{{ $guidance->student_note }}</p>@if($guidance->file_path)<a class="text-indigo-700" target="_blank" href="{{ asset('storage/'.$guidance->file_path) }}">Lihat file mahasiswa</a>@endif</div>
<form method="POST" action="{{ route('guidances.review',$guidance) }}" class="rounded bg-white p-4 shadow">@csrf
<label class="mb-2 block font-semibold">Status</label><select name="status" class="mb-4 w-full rounded border p-2" required>@foreach(['direview','revisi','selesai'] as $s)<option value="{{ $s }}" @selected(old('status',$guidance->status)==$s)>{{ strtoupper($s) }}</option>@endforeach</select>
<label class="mb-2 block font-semibold">Catatan Dosen</label><textarea name="supervisor_note" rows="6" class="mb-4 w-full rounded border p-2" required>{{ old('supervisor_note',$guidance->supervisor_note) }}</textarea>
<button class="rounded bg-indigo-600 px-4 py-2 text-white">Simpan Review</button>
</form>
@endsection
