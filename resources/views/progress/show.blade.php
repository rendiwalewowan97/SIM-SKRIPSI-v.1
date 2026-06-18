@extends('layouts.app')
@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-bold">Tracking Riwayat Bimbingan & Skripsi</h1>
    <p class="text-slate-500">Mahasiswa: {{ $student->name }} · {{ $student->identifier ?: '-' }}</p>
</div>
<!-- <div class="space-y-4">
    <section class="rounded bg-white p-4 shadow">
        <h2 class="mb-3 font-bold">1. Pengajuan Judul</h2>
        @forelse($titles as $t)
            <div class="border-t py-3 first:border-t-0"><div class="font-semibold">{{ $t->title }}</div><div class="text-sm text-slate-500">Status: {{ $t->status }} · Dosen: {{ $t->supervisor->name ?? '-' }} · {{ $t->created_at->format('d/m/Y H:i') }}</div></div>
        @empty <p class="text-slate-500">Belum ada pengajuan judul.</p> @endforelse
    </section>
    <section class="rounded bg-white p-4 shadow">
        <h2 class="mb-3 font-bold">2. Riwayat Bimbingan</h2>
        @forelse($guidances as $g)
            <div class="border-t py-3 first:border-t-0"><div class="font-semibold">{{ strtoupper($g->type) }} - {{ $g->session_date->format('d/m/Y') }}</div><div class="text-sm text-slate-500">Dosen: {{ $g->supervisor->name }} · Status: {{ $g->status }}</div><p class="mt-1 text-sm">Mahasiswa: {{ $g->student_note }}</p><p class="mt-1 text-sm">Dosen: {{ $g->supervisor_note ?: '-' }}</p></div>
        @empty <p class="text-slate-500">Belum ada bimbingan.</p> @endforelse
    </section>
    <section class="rounded bg-white p-4 shadow">
        <h2 class="mb-3 font-bold">3. Pendaftaran & Jadwal Sidang</h2>
        @forelse($exams as $e)
            <div class="border-t py-3 first:border-t-0"><div class="font-semibold">{{ str_replace('_',' ',strtoupper($e->type)) }}</div><div class="text-sm text-slate-500">Status: {{ $e->status }} · Jadwal: {{ optional($e->scheduled_at)->format('d/m/Y H:i') ?? '-' }} · Ruang: {{ $e->room ?? '-' }}</div></div>
        @empty <p class="text-slate-500">Belum ada pendaftaran sidang.</p> @endforelse
    </section>
    <section class="rounded bg-white p-4 shadow">
        <h2 class="mb-3 font-bold">4. Arsip Skripsi</h2>
        @forelse($archives as $a)
            <div class="border-t py-3 first:border-t-0"><a class="font-semibold text-indigo-700" href="{{ route('archives.show',$a) }}">{{ $a->title }}</a><div class="text-sm text-slate-500">Tahun: {{ $a->year }} · Keyword: {{ $a->keywords ?: '-' }}</div></div>
        @empty <p class="text-slate-500">Belum ada arsip.</p> @endforelse
    </section>
</div> -->
@php
    $steps = [
        [
            'title' => 'Pengajuan Judul',
            'desc' => 'Tahap pengajuan judul skripsi',
            'color' => $titles->count() ? 'bg-emerald-500' : 'bg-red-500',
            'items' => $titles,
        ],
        [
            'title' => 'Riwayat Bimbingan',
            'desc' => 'Tahap proses bimbingan skripsi',
            'color' => $guidances->count() ? 'bg-emerald-500' : 'bg-red-500',
            'items' => $guidances,
        ],
        [
            'title' => 'Pendaftaran & Jadwal Sidang',
            'desc' => 'Tahap pendaftaran dan jadwal sidang',
            'color' => $exams->count() ? 'bg-emerald-500' : 'bg-red-500',
            'items' => $exams,
        ],
        [
            'title' => 'Arsip Skripsi',
            'desc' => 'Tahap arsip/finalisasi skripsi',
            'color' => $archives->count() ? 'bg-emerald-500' : 'bg-yellow-400',
            'items' => $archives,
        ],
    ];
@endphp

<div class="mb-6 rounded bg-white p-5 shadow">
    <h2 class="mb-3 text-sm font-bold text-slate-700">LEGENDA</h2>

    <div class="space-y-2 text-sm text-slate-500">
        <div class="flex items-center gap-2">
            <span class="h-3 w-3 rounded-full bg-emerald-500"></span>
            tahapan sudah selesai
        </div>
        <div class="flex items-center gap-2">
            <span class="h-3 w-3 rounded-full bg-yellow-400"></span>
            tahapan belum selesai
        </div>
        <div class="flex items-center gap-2">
            <span class="h-3 w-3 rounded-full bg-red-500"></span>
            tahapan belum dapat dilakukan
        </div>
    </div>
</div>

<div class="relative">
    <div class="absolute left-7 top-0 h-full w-1 bg-slate-200"></div>

    <div class="space-y-6">
        @foreach($steps as $index => $step)
            <section class="relative flex gap-5">
                <div class="z-10 flex h-14 w-14 shrink-0 items-center justify-center rounded-full text-xl font-bold text-white shadow {{ $step['color'] }}">
                    {{ $index + 1 }}
                </div>

                <div class="w-full rounded bg-white p-5 shadow">
                    <h2 class="mb-2 text-xl font-bold text-sky-700">
                        {{ $step['title'] }}
                        <span class="text-base">➜</span>
                    </h2>

                    <p class="mb-4 text-sm text-slate-500">
                        {{ $step['desc'] }}
                    </p>

                    @if($step['title'] == 'Pengajuan Judul')
                        @forelse($titles as $t)
                            <div class="border-t py-3 first:border-t-0">
                                <div class="font-semibold text-slate-700">{{ $t->title }}</div>
                                <div class="text-sm text-slate-500">
                                    Status: {{ $t->status }} ·
                                    Dosen: {{ $t->supervisor->name ?? '-' }} ·
                                    {{ $t->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">--- belum dilakukan ---</p>
                        @endforelse

                    @elseif($step['title'] == 'Riwayat Bimbingan')
                        @forelse($guidances as $g)
                            <div class="border-t py-3 first:border-t-0">
                                <div class="font-semibold text-slate-700">
                                    {{ strtoupper($g->type) }} - {{ $g->session_date->format('d/m/Y') }}
                                </div>
                                <div class="text-sm text-slate-500">
                                    Dosen: {{ $g->supervisor->name }} · Status: {{ $g->status }}
                                </div>
                                <p class="mt-1 text-sm">Mahasiswa: {{ $g->student_note }}</p>
                                <p class="mt-1 text-sm">Dosen: {{ $g->supervisor_note ?: '-' }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">--- belum dilakukan ---</p>
                        @endforelse

                    @elseif($step['title'] == 'Pendaftaran & Jadwal Sidang')
                        @forelse($exams as $e)
                            <div class="border-t py-3 first:border-t-0">
                                <div class="font-semibold text-slate-700">
                                    {{ str_replace('_',' ',strtoupper($e->type)) }}
                                </div>
                                <div class="text-sm text-slate-500">
                                    Status: {{ $e->status }} ·
                                    Jadwal: {{ optional($e->scheduled_at)->format('d/m/Y H:i') ?? '-' }} ·
                                    Ruang: {{ $e->room ?? '-' }}
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">--- belum dilakukan ---</p>
                        @endforelse

                    @elseif($step['title'] == 'Arsip Skripsi')
                        @forelse($archives as $a)
                            <div class="border-t py-3 first:border-t-0">
                                <a class="font-semibold text-indigo-700 hover:underline"
                                   href="{{ route('archives.show',$a) }}">
                                    {{ $a->title }}
                                </a>
                                <div class="text-sm text-slate-500">
                                    Tahun: {{ $a->year }} · Keyword: {{ $a->keywords ?: '-' }}
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">--- belum dilakukan ---</p>
                        @endforelse
                    @endif
                </div>
            </section>
        @endforeach
    </div>
</div>
@endsection
