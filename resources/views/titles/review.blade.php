@extends('layouts.app')

@section('content')
<h1 class="mb-4 text-2xl font-bold">Review Pengajuan Judul</h1>

<div class="mb-4 rounded bg-white p-4 shadow">
    <div class="flex flex-wrap items-start justify-between gap-3">
        <div>
            <h2 class="font-bold">{{ $title->title }}</h2>
            <p class="text-sm text-slate-500">Mahasiswa: {{ $title->student->name }}</p>
        </div>
        <x-status :value="$title->status" />
    </div>

    <div class="mt-4 rounded border bg-slate-50 p-3 text-sm">
        <b>Voting Dosen:</b>
        Setuju {{ $title->setuju_votes_count ?? 0 }} /
        Tidak Setuju {{ $title->tidak_setuju_votes_count ?? 0 }}.
        Minimal setuju: {{ $minimalSetuju }} dari {{ $totalDosen }} dosen.
    </div>

    <p class="mt-3 whitespace-pre-line">{{ $title->background }}</p>
</div>

<form method="POST" action="{{ route('titles.review', $title) }}" class="rounded bg-white p-4 shadow">
    @csrf

    <label class="mb-2 block font-semibold">Status Judul</label>
    <select name="status" class="mb-4 w-full rounded border p-2" required>
        @foreach(['diajukan','disetujui','ditolak','revisi'] as $s)
            <option value="{{ $s }}" @selected(old('status', $title->status) == $s)>
                {{ strtoupper($s) }}
            </option>
        @endforeach
    </select>

    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="mb-2 block font-semibold">Dosen Pembimbing 1</label>
            <select name="supervisor_1_id" class="mb-4 w-full rounded border p-2">
                <option value="">- Pilih dosen -</option>
                @foreach($dosens as $d)
                    <option value="{{ $d->id }}" @selected(old('supervisor_1_id', $title->supervisor_1_id ?? $title->supervisor_id) == $d->id)>
                        {{ $d->name }} {{ $d->identifier ? '- '.$d->identifier : '' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-2 block font-semibold">Dosen Pembimbing 2</label>
            <select name="supervisor_2_id" class="mb-4 w-full rounded border p-2">
                <option value="">- Pilih dosen -</option>
                @foreach($dosens as $d)
                    <option value="{{ $d->id }}" @selected(old('supervisor_2_id', $title->supervisor_2_id) == $d->id)>
                        {{ $d->name }} {{ $d->identifier ? '- '.$d->identifier : '' }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <label class="mb-2 block font-semibold">Catatan Jurusan</label>
    <textarea name="notes" rows="5" class="mb-4 w-full rounded border p-2">{{ old('notes', $title->notes) }}</textarea>

    <button class="rounded bg-indigo-600 px-4 py-2 text-white">Simpan Alur Judul</button>
</form>
@endsection
