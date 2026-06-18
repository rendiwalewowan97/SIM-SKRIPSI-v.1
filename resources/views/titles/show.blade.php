@extends('layouts.app')
@section('content')
<div class="mx-auto max-w-4xl rounded-xl bg-white p-6 shadow">
    <div class="flex justify-between gap-3 border-b pb-4">
        <div>
            <h1 class="text-2xl font-bold">{{ $title->title }}</h1>
            <p class="text-sm text-slate-500">Detail pengajuan judul skripsi</p>
        </div>
        <x-status :value="$title->status" />
    </div>

    <dl class="mt-6 grid gap-5 md:grid-cols-2">
        <div><dt class="text-sm text-slate-500">Mahasiswa</dt><dd>{{ $title->student->name }}</dd></div>
        <div><dt class="text-sm text-slate-500">Jumlah SKS</dt><dd>{{ $title->sks ?? '-' }}</dd></div>
        <div><dt class="text-sm text-slate-500">Pembimbing 1</dt><dd>{{ $title->supervisor1->name ?? $title->supervisor->name ?? '-' }}</dd></div>
        <div><dt class="text-sm text-slate-500">Pembimbing 2</dt><dd>{{ $title->supervisor2->name ?? '-' }}</dd></div>
        <div><dt class="text-sm text-slate-500">Tanggal Lolos Voting</dt><dd>{{ optional($title->approved_at)->format('d/m/Y H:i') ?? '-' }}</dd></div>
        <div><dt class="text-sm text-slate-500">Tanggal Penetapan Pembimbing</dt><dd>{{ optional($title->assigned_at)->format('d/m/Y H:i') ?? '-' }}</dd></div>
        <div class="md:col-span-2"><dt class="text-sm text-slate-500">Catatan</dt><dd>{{ $title->notes ?: '-' }}</dd></div>
    </dl>

    <div class="mt-8 border-t pt-6">
        <h2 class="mb-3 font-semibold">Latar Belakang</h2>
        <div class="rounded bg-slate-50 p-4"><p class="whitespace-pre-line">{{ $title->background ?: '-' }}</p></div>
    </div>

    <div class="mt-6 rounded-lg border bg-slate-50 p-4">
        <h2 class="mb-2 font-semibold">Hasil Voting Dosen</h2>
        <p>Setuju: <b>{{ $title->setuju_votes_count ?? 0 }}</b> | Tidak Setuju: <b>{{ $title->tidak_setuju_votes_count ?? 0 }}</b></p>
        <p class="text-sm text-slate-500">Syarat lolos voting: minimal {{ $minimalSetuju ?? 8 }} suara setuju dari {{ $totalDosen ?? 15 }} dosen.</p>

        @if(auth()->user()->isDosen() && in_array($title->status, ['diajukan','revisi']))
        <form method="POST" action="{{ route('titles.vote', $title) }}" class="mt-4 flex flex-wrap gap-2">
            @csrf
            <button name="vote" value="setuju" class="rounded bg-green-600 px-4 py-2 text-white">Setuju</button>
            <button name="vote" value="tidak_setuju" class="rounded bg-red-600 px-4 py-2 text-white">Tidak Setuju</button>
            @if($myVote)<span class="py-2 text-sm text-slate-500">Voting Anda: {{ str_replace('_',' ', strtoupper($myVote->vote)) }}</span>@endif
        </form>
        @elseif(auth()->user()->isDosen())
            <p class="mt-3 text-sm text-slate-500">Voting sudah selesai karena status judul bukan diajukan/revisi.</p>
        @endif
    </div>

    @if(auth()->user()->isJurusan())
    <div class="mt-6 border-t pt-6">
        <a href="{{ route('titles.edit', $title) }}" class="rounded bg-indigo-600 px-4 py-2 text-white">Tetapkan Pembimbing</a>
    </div>
    @endif

    @if($title->status === 'disetujui' && auth()->user()->isMahasiswa())
    <div class="mt-6 border-t pt-6">
        <a href="{{ route('titles.approvalLetter', $title) }}" target="_blank" class="rounded bg-green-600 px-4 py-2 text-white">Download Surat Penunjukan Pembimbing</a>
    </div>
    @endif
</div>
@endsection
