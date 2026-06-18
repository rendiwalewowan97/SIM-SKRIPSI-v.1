@extends('layouts.app')

@section('content')
<h1 class="mb-4 text-2xl font-bold">
    {{ isset($guidance) ? 'Edit / Kirim Ulang Bimbingan' : 'Ajukan Bimbingan' }}
</h1>

@if(!$approved)
<div class="mb-4 rounded border border-yellow-200 bg-yellow-50 p-3 text-yellow-700">
    Belum ada judul yang disetujui. Anda tetap bisa menyimpan bimbingan, tetapi alur ideal dimulai setelah judul disetujui jurusan.
</div>
@endif

<form
    method="POST"
    enctype="multipart/form-data"
    action="{{ isset($guidance) ? route('guidances.update', $guidance) : route('guidances.store') }}"
    class="rounded bg-white p-4 shadow">
    @csrf

    @isset($guidance)
    @method('PUT')
    @endisset

    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="mb-2 block font-semibold">Dosen Pembimbing</label>

            <select name="supervisor_id" class="mb-4 w-full rounded border p-2" required>
                @foreach($dosens as $d)
                <option
                    value="{{ $d->id }}"
                    @selected(old('supervisor_id', $guidance->supervisor_id ?? optional($approved)->supervisor_id) == $d->id)
                    >
                    {{ $d->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-2 block font-semibold">Jenis Bimbingan</label>

            <select name="type" class="mb-4 w-full rounded border p-2" required>
                @foreach(['proposal' => 'Proposal', 'skripsi' => 'Skripsi'] as $k => $v)
                <option
                    value="{{ $k }}"
                    @selected(old('type', $guidance->type ?? '') == $k)
                    >
                    {{ $v }}
                </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="mb-2 block font-semibold">Tanggal</label>

            <input
                type="date"
                name="session_date"
                value="{{ old('session_date', isset($guidance) && $guidance->session_date ? $guidance->session_date->format('Y-m-d') : now()->format('Y-m-d')) }}"
                class="mb-4 w-full rounded border p-2"
                required>
        </div>

        <div>
            <label class="mb-2 block font-semibold">Bab/Topik</label>

            <input
                name="chapter"
                value="{{ old('chapter', $guidance->chapter ?? '') }}"
                class="mb-4 w-full rounded border p-2"
                placeholder="Contoh: BAB I / Metodologi">
        </div>
    </div>

    <label class="mb-2 block font-semibold">Catatan Mahasiswa</label>

    <textarea
        name="student_note"
        rows="6"
        class="mb-4 w-full rounded border p-2"
        required>{{ old('student_note', $guidance->student_note ?? '') }}</textarea>

    <label class="mb-2 block font-semibold">
        Upload File Proposal/Skripsi/Naskah Revisi
    </label>

    <input
        type="file"
        name="file"
        class="mb-4 w-full rounded border p-2">

    @isset($guidance)
    @if($guidance->file_path)
    <p class="mb-4 text-sm">
        File saat ini:
        <a
            class="text-indigo-700"
            target="_blank"
            href="{{ asset('storage/' . $guidance->file_path) }}">
            Download
        </a>
    </p>
    @endif
    @endisset

    <button class="rounded bg-indigo-600 px-4 py-2 text-white">
        {{ isset($guidance) ? 'Kirim Ulang' : 'Kirim ke Dosen' }}
    </button>
</form>
@endsection