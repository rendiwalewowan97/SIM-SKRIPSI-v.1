@extends('layouts.app')

@section('content')
<div class="mb-4 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold">Monitoring Progress Mahasiswa</h1>
        <p class="text-sm text-slate-500">
            Alur : Pengajuan Judul → Bimbingan Proposal → Seminar Proposal →
            Bimbingan Skripsi → Sidang Skripsi → Arsip.
        </p>
    </div>
</div>

{{-- Pencarian --}}
<form class="mb-4 flex gap-2">
    <input
        type="text"
        name="q"
        value="{{ request('q') }}"
        class="w-full rounded border p-2"
        placeholder="Cari mahasiswa/NIM">
        
    <button class="rounded bg-slate-800 px-4 py-2 text-white hover:bg-slate-900">
        Cari
    </button>
</form>

<div class="overflow-x-auto rounded-lg bg-white shadow">
    <table class="w-full text-sm">
        <thead class="bg-slate-100">
            <tr>
                <th class="px-4 py-3 text-left">Mahasiswa</th>
                <th class="px-4 py-3 text-left">NIM</th>
                <th class="px-4 py-3 text-center">Progress</th>
                <th class="px-4 py-3 text-center">Judul</th>
                <th class="px-4 py-3 text-center">Proposal</th>
                <th class="px-4 py-3 text-center">Sempro</th>
                <th class="px-4 py-3 text-center">Skripsi</th>
                <th class="px-4 py-3 text-center">Sidang</th>
                <th class="px-4 py-3 text-center">Arsip</th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @forelse($students as $s)
            <tr class="hover:bg-slate-50">
                <td class="px-4 py-3 font-medium">
                    {{ $s->name }}
                </td>

                <td class="px-4 py-3">
                    {{ $s->identifier ?: '-' }}
                </td>

                <td class="px-4 py-3">
                    <div class="flex items-center gap-2">
                        <div class="h-2 flex-1 rounded bg-slate-200">
                            <div
                                class="h-2 rounded bg-indigo-600"
                                style="width: {{ $s->progress_percent }}%">
                            </div>
                        </div>
                        <span class="font-semibold text-indigo-700">
                            {{ $s->progress_percent }}%
                        </span>
                    </div>
                </td>

                <td class="px-4 py-3 text-center">
                    @if($s->approved_title)
                        <span class="rounded bg-green-100 px-2 py-1 text-xs font-medium text-green-700">
                            Ya
                        </span>
                    @else
                        <span class="rounded bg-red-100 px-2 py-1 text-xs font-medium text-red-700">
                            Belum
                        </span>
                    @endif
                </td>

                <td class="px-4 py-3 text-center">
                    {{ $s->proposal_guidance_count }}
                </td>

                <td class="px-4 py-3 text-center">
                    {{ $s->proposal_exam->status ?? '-' }}
                </td>

                <td class="px-4 py-3 text-center">
                    {{ $s->skripsi_guidance_count }}
                </td>

                <td class="px-4 py-3 text-center">
                    {{ $s->skripsi_exam->status ?? '-' }}
                </td>

                <td class="px-4 py-3 text-center">
                    @if($s->archive)
                        <span class="rounded bg-green-100 px-2 py-1 text-xs font-medium text-green-700">
                            Ada
                        </span>
                    @else
                        <span class="rounded bg-yellow-100 px-2 py-1 text-xs font-medium text-yellow-700">
                            Belum
                        </span>
                    @endif
                </td>

                <td class="px-4 py-3">
                    <div class="flex justify-center gap-2">

                        {{-- Timeline --}}
                        <a href="{{ route('progress.show', $s) }}"
                        class="rounded bg-indigo-600 px-3 py-2 text-xs font-medium text-white hover:bg-indigo-700">
                            Timeline
                        </a>

                        {{-- Tracking --}}
                        <a href="{{ route('guidances.index') }}"
                        class="rounded bg-slate-600 px-3 py-2 text-xs font-medium text-white hover:bg-slate-700">
                            Tracking
                        </a>

                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="px-4 py-6 text-center text-slate-500">
                    Belum ada data mahasiswa.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $students->links() }}
</div>
@endsection