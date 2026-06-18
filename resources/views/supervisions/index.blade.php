@extends('layouts.app')
@section('content')
<h1 class="mb-4 text-2xl font-bold">Daftar Mahasiswa Bimbingan</h1>
<div class="overflow-x-auto rounded bg-white shadow">
<table class="w-full text-sm"><thead class="bg-slate-100"><tr><th class="p-3 text-left">Mahasiswa</th><th>Judul</th><th>Bimbingan</th><th>Terakhir</th><th>Proposal</th><th>Skripsi</th><th>Aksi</th></tr></thead><tbody>
@forelse($students as $s)
<tr class="border-t"><td class="p-3 font-medium">{{ $s->name }}<br><span class="text-slate-500">{{ $s->identifier }}</span></td><td>{{ $s->title_submission->title }}</td><td>{{ $s->guidance_count }} kali</td><td>{{ optional($s->last_guidance)->session_date?->format('d/m/Y') ?? '-' }}</td><td>{{ $s->proposal_exam->status ?? '-' }}</td><td>{{ $s->skripsi_exam->status ?? '-' }}</td><td><a class="text-indigo-700" href="{{ route('progress.show',$s) }}">Tracking</a></td></tr>
@empty<tr><td colspan="7" class="p-4 text-center text-slate-500">Belum ada mahasiswa bimbingan.</td></tr>@endforelse
</tbody></table>
</div>
@endsection
